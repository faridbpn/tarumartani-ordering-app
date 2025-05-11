<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $table = Table::create([
                'nomor_meja' => $i,
                'token' => Str::random(64),
            ]);
        }
    }
}
