<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menuItems = [
            [
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial dengan ayam dan telur',
                'price' => 25000,
                'category' => 'Makanan',
                'image' => 'images/nasi-goreng.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh',
                'description' => 'Es teh manis segar',
                'price' => 5000,
                'category' => 'Minuman',
                'image' => 'images/es-teh.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh',
                'description' => 'Es teh manis segar',
                'price' => 5000,
                'category' => 'Minuman',
                'image' => 'images/es-teh.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh',
                'description' => 'Es teh manis segar',
                'price' => 5000,
                'category' => 'Minuman',
                'image' => 'images/es-teh.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh',
                'description' => 'Es teh manis segar',
                'price' => 5000,
                'category' => 'Minuman',
                'image' => 'images/es-teh.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($menuItems as $item) {
            Menu::create($item);
        }
    }
}