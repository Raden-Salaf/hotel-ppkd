<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['room.roomType', 'handler'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::available()->with('roomType')->get();
        return view('admin.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string|max:20',
            'check_in'    => 'required|date|after_or_equal:today',
            'check_out'   => 'required|date|after:check_in',
            'notes'       => 'nullable|string',
        ]);

        $room         = Room::findOrFail($validated['room_id']);
        $checkIn      = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut     = \Carbon\Carbon::parse($validated['check_out']);
        $totalNights  = $checkIn->diffInDays($checkOut);

        $booking = Booking::create([
            ...$validated,
            'booking_code'  => Booking::generateCode(),
            'total_nights'  => $totalNights,
            'total_price'   => $room->roomType->price_per_night * $totalNights,
            'status'        => 'pending',
            'handled_by'    => auth()->id(),
        ]);

        // Update status kamar jadi occupied
        $room->update(['status' => 'occupied']);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} berhasil dibuat.");
    }

    public function show(Booking $booking)
    {
        $booking->load(['room.roomType', 'handler', 'fnbOrders.items.menu', 'review']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        // Bebaskan kamar kalau checkout atau cancel
        if (in_array($request->status, ['checked_out', 'cancelled'])) {
            $booking->room->update(['status' => 'available']);
        }

        return back()->with('success', 'Status booking berhasil diupdate.');
    }

    public function destroy(Booking $booking)
    {
        $booking->room->update(['status' => 'available']);
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }
}