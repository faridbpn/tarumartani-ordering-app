<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Main Course'],
            ['name' => 'Appetizer'],
            ['name' => 'Dessert'],
            ['name' => 'Beverage'],
            ['name' => 'Specials']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}