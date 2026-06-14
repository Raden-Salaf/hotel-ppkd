<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'            => 'Standard',
                'description'     => 'Kamar standar nyaman untuk 1-2 orang.',
                'price_per_night' => 450000,
                'max_occupancy'   => 2,
                'facilities'      => ['AC', 'WiFi', 'TV', 'Kamar Mandi Dalam'],
            ],
            [
                'name'            => 'Deluxe',
                'description'     => 'Kamar deluxe dengan pemandangan taman.',
                'price_per_night' => 650000,
                'max_occupancy'   => 2,
                'facilities'      => ['AC', 'WiFi', 'TV', 'Bathtub', 'Mini Bar'],
            ],
            [
                'name'            => 'Suite',
                'description'     => 'Suite mewah dengan ruang tamu terpisah.',
                'price_per_night' => 1500000,
                'max_occupancy'   => 4,
                'facilities'      => ['AC', 'WiFi', 'TV', 'Bathtub', 'Mini Bar', 'Ruang Tamu', 'Dapur Kecil'],
            ],
        ];

        foreach ($types as $type) {
            RoomType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}
