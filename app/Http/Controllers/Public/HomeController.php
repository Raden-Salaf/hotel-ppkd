<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Review;

class HomeController extends Controller
{
    // Landing page
    public function index()
    {
        $roomTypes     = RoomType::withCount('rooms')->get();
        $availableCount = Room::where('status', 'available')->count();
        $reviews       = Review::where('is_published', true)
            ->where('rating', '>=', 4)
            ->latest()->limit(3)->get();

        return view('public.home', compact('roomTypes', 'availableCount', 'reviews'));
    }

    // Halaman daftar kamar
    public function rooms()
    {
        $rooms       = Room::with('roomType')
            ->where('status', 'available')
            ->get()
            ->groupBy('room_type_id');

        $roomTypes_model   = RoomType::all()->keyBy('id'); // ← nama konsisten: $roomTypes

        return view('public.rooms', compact('rooms', 'roomTypes_model'));
    }
}
