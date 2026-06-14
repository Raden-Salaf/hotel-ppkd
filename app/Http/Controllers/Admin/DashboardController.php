<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FnbOrder;
use App\Models\Room;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_rooms'     => Room::count(),
            'available_rooms' => Room::available()->count(),
            'active_bookings' => Booking::whereIn('status', ['confirmed', 'checked_in'])->count(),
            'revenue_today'   => Booking::whereDate('created_at', today())
                                    ->whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
                                    ->sum('total_price'),
        ];

        $recent_bookings = Booking::with(['room.roomType'])
            ->latest()->limit(5)->get();

        $recent_fnb_orders = FnbOrder::with(['items.menu'])
            ->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_fnb_orders'));
    }
}