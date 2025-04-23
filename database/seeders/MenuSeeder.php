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
                'category' => 'Main Course',
                'status' => 'available'
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Grilled chicken skewers with peanut sauce, served with rice cakes',
                'price' => 25000,
                'category' => 'Appetizer',
                'status' => 'available'
            ],
            [
                'name' => 'Es Campur',
                'description' => 'Mixed ice dessert with fruits, jelly, syrup, and condensed milk',
                'price' => 18000,
                'category' => 'Dessert',
                'status' => 'seasonal'
            ],
            [
                'name' => 'Soto Betawi',
                'description' => 'Jakarta-style beef soup with coconut milk, served with rice',
                'price' => 28000,
                'category' => 'Main Course',
                'status' => 'out_of_stock'
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Sweet iced tea with lemon, perfect Indonesian-style refreshment',
                'price' => 8000,
                'category' => 'Beverage',
                'status' => 'available'
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Indonesian salad with mixed vegetables, tofu, tempeh and peanut sauce',
                'price' => 22000,
                'category' => 'Appetizer',
                'status' => 'available'
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}