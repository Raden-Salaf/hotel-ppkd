<?php

namespace Database\Seeders;

use App\Models\FnbCategory;
use Illuminate\Database\Seeder;

class FnbCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan', 'icon' => '🍽️'],
            ['name' => 'Minuman', 'icon' => '🥤'],
            ['name' => 'Dessert', 'icon' => '🍰'],
        ];

        foreach ($categories as $cat) {
            FnbCategory::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}