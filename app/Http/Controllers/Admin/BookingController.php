<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FnbMenu;
use App\Models\FnbOrder;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['room.roomType', 'handler', 'fnbOrders'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms    = Room::available()->with('roomType')->get();
        $fnbMenus = FnbMenu::with('category')->where('status', 'available')->get()->groupBy('fnb_category_id');
        $fnbCategories = \App\Models\FnbCategory::all()->keyBy('id');

        return view('admin.bookings.create', compact('rooms', 'fnbMenus', 'fnbCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'              => 'required|exists:rooms,id',
            'guest_name'           => 'required|string|max:255',
            'guest_email'          => 'required|email',
            'guest_phone'          => 'required|string|max:20',
            'check_in'             => 'required|date|after_or_equal:today',
            'check_out'            => 'required|date|after:check_in',
            'notes'                => 'nullable|string',
            'fnb_items'            => 'nullable|array',
            'fnb_items.*.menu_id'  => 'exists:fnb_menus,id',
            // 'fnb_items.*.qty'      => 'integer|min:1',
        ]);

        $room        = Room::findOrFail($validated['room_id']);
        $checkIn     = Carbon::parse($validated['check_in']);
        $checkOut    = Carbon::parse($validated['check_out']);
        $totalNights = $checkIn->diffInDays($checkOut);

        // Buat booking
        $booking = Booking::create([
            'booking_code'   => Booking::generateCode(),
            'room_id'        => $room->id,
            'guest_name'     => $validated['guest_name'],
            'guest_email'    => $validated['guest_email'],
            'guest_phone'    => $validated['guest_phone'],
            'check_in'       => $validated['check_in'],
            'check_out'      => $validated['check_out'],
            'total_nights'   => $totalNights,
            'total_price'    => $room->roomType->price_per_night * $totalNights,
            'status'         => 'confirmed', // resepsionis langsung confirmed
            'payment_status' => 'unpaid',
            'handled_by'     => auth()->id(),
            'notes'          => $validated['notes'] ?? null,
        ]);

        // Update status kamar
        $room->update(['status' => 'occupied']);

        $fnbItems = collect($request->fnb_items ?? [])
            ->filter(fn($item) => !empty($item['qty']) && (int)$item['qty'] > 0)
            ->values()
            ->toArray();

        // Proses F&B kalau ada
        if (!empty($fnbItems)) {
            $this->processFnbOrder($booking, $fnbItems);
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking {$booking->booking_code} berhasil dibuat.");
    }

    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'handler', 'fnbOrders.items.menu', 'review']);
        $fnbMenus      = FnbMenu::with('category')->where('status', 'available')->get()->groupBy('fnb_category_id');
        $fnbCategories = \App\Models\FnbCategory::all()->keyBy('id');

        return view('admin.bookings.show', compact('booking', 'fnbMenus', 'fnbCategories'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'checked_out') {
            $data['payment_status'] = 'paid';
            $data['paid_at']        = now();
            $booking->room->update(['status' => 'available']);
        }

        if ($request->status === 'cancelled') {
            $booking->room->update(['status' => 'available']);
        }

        $booking->update($data);

        return back()->with('success', 'Status booking berhasil diupdate.');
    }

    public function destroy(Booking $booking)
    {
        $booking->room->update(['status' => 'available']);
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }

    // Tambah F&B ke booking yang sudah ada
    public function addFnb(Request $request, Booking $booking)
    {
        // Tidak perlu validasi min:1 di sini, filter manual saja
        $fnbItems = collect($request->fnb_items ?? [])
            ->filter(fn($item) => !empty($item['qty']) && (int)$item['qty'] > 0)
            ->values()
            ->toArray();

        if (empty($fnbItems)) {
            return back()->with('error', 'Pilih minimal 1 menu F&B.');
        }

        $this->processFnbOrder($booking, $fnbItems);

        return back()->with('success', 'Order F&B berhasil ditambahkan.');
    }

    private function processFnbOrder(Booking $booking, array $items): void
    {
        $totalPrice = 0;
        $orderItems = [];

        foreach ($items as $item) {
            // Support key 'menu_id' dan 'qty'
            $menuId = $item['menu_id'] ?? null;
            $qty    = (int)($item['qty'] ?? 0);

            if (!$menuId || $qty <= 0) continue;

            $menu      = FnbMenu::findOrFail($menuId);
            $subtotal  = $menu->price * $qty;
            $totalPrice += $subtotal;

            $orderItems[] = [
                'fnb_menu_id' => $menu->id,
                'quantity'    => $qty,
                'unit_price'  => $menu->price,
                'subtotal'    => $subtotal,
            ];
        }

        if (empty($orderItems)) return;

        $order = FnbOrder::create([
            'order_code'  => FnbOrder::generateCode(),
            'booking_id'  => $booking->id,
            'room_number' => $booking->room->room_number,
            'total_price' => $totalPrice,
            'status'      => 'queue',
            'handled_by'  => auth()->id(),
        ]);

        $order->items()->createMany($orderItems);
    }

    public function invoice(Booking $booking)
    {
        // Pastikan semua relasi yang dibutuhkan di-load
        $booking->load([
            'room.roomType',
            'handler',
            'fnbOrders.items.menu', // ← ini penting agar F&B muncul
        ]);

        return view('admin.bookings.invoice', compact('booking'));
    }
}
