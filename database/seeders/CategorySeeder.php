<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Makanan'],
            ['name' => 'Minuman'],
            ['name' => 'Snack'],
            ['name' => 'Special']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}