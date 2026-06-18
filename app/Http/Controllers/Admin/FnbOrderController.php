<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FnbMenu;
use App\Models\FnbOrder;
use App\Models\FnbOrderItem;
use Illuminate\Http\Request;

class FnbOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = FnbOrder::with(['items.menu', 'booking', 'handler'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(15);

        return view('admin.fnb.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number'         => 'required|string',
            'booking_id'          => 'nullable|exists:bookings,id',
            'items'               => 'required|array|min:1',
            'items.*.fnb_menu_id' => 'required|exists:fnb_menus,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.notes'       => 'nullable|string',
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $menu      = FnbMenu::findOrFail($item['fnb_menu_id']);
            $subtotal  = $menu->price * $item['quantity'];
            $totalPrice += $subtotal;

            $orderItems[] = [
                'fnb_menu_id' => $menu->id,
                'quantity'    => $item['quantity'],
                'unit_price'  => $menu->price,
                'subtotal'    => $subtotal,
                'notes'       => $item['notes'] ?? null,
            ];
        }

        $order = FnbOrder::create([
            'order_code'  => FnbOrder::generateCode(),
            'booking_id'  => $request->booking_id, // null = standalone
            'room_number' => $request->room_number,
            'total_price' => $totalPrice,
            'status'      => 'queue',
            'handled_by'  => auth()->id(),
        ]);

        $order->items()->createMany($orderItems);

        return back()->with('success', "Order {$order->order_code} berhasil dibuat.");
    }

    public function updateStatus(Request $request, FnbOrder $fnbOrder)
    {
        $request->validate([
            'status' => 'required|in:queue,processing,done,cancelled',
        ]);

        $fnbOrder->update(['status' => $request->status]);

        return back()->with('success', 'Status order berhasil diupdate.');
    }
}
