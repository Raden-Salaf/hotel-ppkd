<?php

namespace Database\Seeders;

use App\Models\FnbCategory;
use App\Models\FnbMenu;
use App\Models\User;
use Illuminate\Database\Seeder;

class FnbMenuSeeder extends Seeder
{
    public function run(): void
    {
        $makanan  = FnbCategory::where('name', 'Makanan')->value('id');
        $minuman  = FnbCategory::where('name', 'Minuman')->value('id');
        $dessert  = FnbCategory::where('name', 'Dessert')->value('id');
        $adminId  = User::where('email', 'fnb@hotel.com')->value('id');

        $menus = [
            ['name' => 'Nasi Goreng Spesial', 'fnb_category_id' => $makanan, 'price' => 40000,  'status' => 'available'],
            ['name' => 'Soto Ayam',            'fnb_category_id' => $makanan, 'price' => 35000,  'status' => 'available'],
            ['name' => 'Beef Steak',           'fnb_category_id' => $makanan, 'price' => 150000, 'status' => 'available'],
            ['name' => 'Gado-Gado',            'fnb_category_id' => $makanan, 'price' => 30000,  'status' => 'available'],
            ['name' => 'Es Teh Manis',         'fnb_category_id' => $minuman, 'price' => 10000,  'status' => 'available'],
            ['name' => 'Jus Alpukat',          'fnb_category_id' => $minuman, 'price' => 25000,  'status' => 'available'],
            ['name' => 'Kopi Susu',            'fnb_category_id' => $minuman, 'price' => 20000,  'status' => 'available'],
            ['name' => 'Tiramisu',             'fnb_category_id' => $dessert, 'price' => 55000,  'status' => 'available'],
            ['name' => 'Pudding Coklat',       'fnb_category_id' => $dessert, 'price' => 25000,  'status' => 'available'],
        ];

        foreach ($menus as $menu) {
            FnbMenu::firstOrCreate(
                ['name' => $menu['name']],
                [...$menu, 'created_by' => $adminId]
            );
        }
    }
}