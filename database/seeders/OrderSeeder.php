<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get some users and menus to create orders
        $users = User::take(5)->get();
        $menus = Menu::all();
        
        if ($users->isEmpty() || $menus->isEmpty()) {
            $this->command->info('Please run UserSeeder and MenuSeeder first!');
            return;
        }

        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        // Create 20 dummy orders
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'total_amount' => 0, // Will be updated after order items are created
            ]);

            // Create 1-5 random order items for each order
            $numItems = rand(1, 5);
            $totalAmount = 0;
            
            for ($j = 0; $j < $numItems; $j++) {
                $menu = $menus->random();
                $quantity = rand(1, 3);
                $price = $menu->price;
                $subtotal = $quantity * $price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
                
                $totalAmount += $subtotal;
            }
            
            // Update the order's total amount
            $order->update(['total_amount' => $totalAmount]);
        }
        
        $this->command->info('Orders and order items seeded successfully!');
    }
} 