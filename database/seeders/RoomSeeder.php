<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $standard = RoomType::where('name', 'Standard')->value('id');
        $deluxe   = RoomType::where('name', 'Deluxe')->value('id');
        $suite    = RoomType::where('name', 'Suite')->value('id');

        $rooms = [
            // Lantai 1 — Standard
            ['room_number' => '101', 'floor' => 1, 'room_type_id' => $standard, 'status' => 'available'],
            ['room_number' => '102', 'floor' => 1, 'room_type_id' => $standard, 'status' => 'available'],
            ['room_number' => '103', 'floor' => 1, 'room_type_id' => $standard, 'status' => 'available'],
            ['room_number' => '104', 'floor' => 1, 'room_type_id' => $standard, 'status' => 'maintenance'],

            // Lantai 2 — Deluxe
            ['room_number' => '201', 'floor' => 2, 'room_type_id' => $deluxe, 'status' => 'available'],
            ['room_number' => '202', 'floor' => 2, 'room_type_id' => $deluxe, 'status' => 'available'],
            ['room_number' => '203', 'floor' => 2, 'room_type_id' => $deluxe, 'status' => 'available'],
            ['room_number' => '204', 'floor' => 2, 'room_type_id' => $deluxe, 'status' => 'available'],

            // Lantai 3 — Suite
            ['room_number' => '301', 'floor' => 3, 'room_type_id' => $suite, 'status' => 'available'],
            ['room_number' => '302', 'floor' => 3, 'room_type_id' => $suite, 'status' => 'available'],
            ['room_number' => '303', 'floor' => 3, 'room_type_id' => $suite, 'status' => 'maintenance'],
            ['room_number' => '304', 'floor' => 3, 'room_type_id' => $suite, 'status' => 'available'],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(['room_number' => $room['room_number']], $room);
        }
    }
}