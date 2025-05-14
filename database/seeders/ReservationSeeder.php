<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please seed users first.');
            return;
        }

        $serviceTypes = ['dinner', 'lunch', 'meeting', 'wedding', 'other'];
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $date = Carbon::now()->addDays(rand(1, 30));
            $time = rand(10, 21) . ':00'; // between 10:00 to 21:00

            Reservation::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '08' . rand(111111111, 999999999),
                'guest_count' => rand(1, 10),
                'reservation_datetime' => $date->format('Y-m-d') . ' ' . $time,
                'service_type' => $serviceTypes[array_rand($serviceTypes)],
                'special_requests' => rand(0, 1) ? 'Please prepare vegetarian food.' : null,
                'status' => $statuses[array_rand($statuses)],
                'admin_notes' => rand(0, 1) ? 'Handled by staff A' : null,
            ]);
        }

        $this->command->info('Reservations seeded successfully!');
    }
}
