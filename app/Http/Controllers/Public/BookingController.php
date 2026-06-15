<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Form pemesanan
    public function create(Room $room)
    {
        // Pastikan kamar masih tersedia
        if ($room->status !== 'available') {
            return redirect()->route('rooms')
                ->with('error', 'Maaf, kamar ini sudah tidak tersedia.');
        }

        $room->load('roomType');
        return view('public.booking-form', compact('room'));
    }

    // Proses simpan booking
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string|max:20',
            'check_in'    => 'required|date|after_or_equal:today',
            'check_out'   => 'required|date|after:check_in',
            'notes'       => 'nullable|string|max:500',
        ]);

        // Hitung otomatis
        $checkIn     = Carbon::parse($validated['check_in']);
        $checkOut    = Carbon::parse($validated['check_out']);
        $totalNights = $checkIn->diffInDays($checkOut);
        $totalPrice  = $room->roomType->price_per_night * $totalNights;

        // Simpan booking
        $booking = Booking::create([
            'booking_code' => Booking::generateCode(),
            'room_id'      => $room->id,
            'guest_name'   => $validated['guest_name'],
            'guest_email'  => $validated['guest_email'],
            'guest_phone'  => $validated['guest_phone'],
            'check_in'     => $validated['check_in'],
            'check_out'    => $validated['check_out'],
            'total_nights' => $totalNights,
            'total_price'  => $totalPrice,
            'status'       => 'pending', // menunggu konfirmasi admin
            'notes'        => $validated['notes'],
        ]);

        // Update status kamar jadi occupied
        $room->update(['status' => 'occupied']);

        return redirect()->route('booking.success', $booking);
    }

    // Halaman sukses
    public function success(Booking $booking)
    {
        $booking->load('room.roomType');
        return view('public.booking-success', compact('booking'));
    }
}
