<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting! Roles dulu sebelum Users, RoomType dulu sebelum Rooms
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            FnbCategorySeeder::class,
            FnbMenuSeeder::class,
        ]);
    }
}