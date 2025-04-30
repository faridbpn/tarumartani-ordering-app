<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            [
                'name' => 'Nasi Goreng Special',
                'description' => 'Traditional Indonesian fried rice with special sauce, chicken, and prawns',
                'price' => 35000,
                'category_id' => 1, 
                'is_available' => true
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Grilled chicken skewers with peanut sauce, served with rice cakes',
                'price' => 25000,
                'category_id' => 1, 
                'is_available' => true
            ],
            [
                'name' => 'Es Campur',
                'description' => 'Mixed ice dessert with fruits, jelly, syrup, and condensed milk',
                'price' => 18000,
                'category_id' => 2, 
                'is_available' => true
            ],
            [
                'name' => 'Soto Betawi',
                'description' => 'Jakarta-style beef soup with coconut milk, served with rice',
                'price' => 28000,
                'category_id' => 1, 
                'is_available' => true
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Sweet iced tea with lemon, perfect Indonesian-style refreshment',
                'price' => 8000,
                'category_id' => 2, 
                'is_available' => true
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Indonesian salad with mixed vegetables, tofu, tempeh and peanut sauce',
                'price' => 22000,
                'category_id' => 1, 
                'is_available' => true
            ]
            // 1 makanan 2 minuman 3 snack 4 spesial
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}