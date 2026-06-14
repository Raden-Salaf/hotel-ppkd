<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        User::firstOrCreate(
            ['email' => 'super@hotel.com'],
            [
                'name'      => 'Super Admin',
                'password'  => 'password123', // auto-hash via cast 'hashed'
                'role_id'   => Role::where('slug', 'superadmin')->value('id'),
                'is_active' => true,
            ]
        );

        // Admin Hotel
        User::firstOrCreate(
            ['email' => 'hotel@hotel.com'],
            [
                'name'      => 'Admin Hotel',
                'password'  => 'password123',
                'role_id'   => Role::where('slug', 'admin_hotel')->value('id'),
                'is_active' => true,
            ]
        );

        // Admin F&B
        User::firstOrCreate(
            ['email' => 'fnb@hotel.com'],
            [
                'name'      => 'Admin F&B',
                'password'  => 'password123',
                'role_id'   => Role::where('slug', 'admin_fnb')->value('id'),
                'is_active' => true,
            ]
        );
    }
}