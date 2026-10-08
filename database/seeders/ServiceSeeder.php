<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Continental Breakfast', 'category' => 'Restaurant', 'price' => 22.00, 'description' => 'Fresh pastries, fruit, eggs, coffee and juice.'],
            ['name' => 'Full Buffet Breakfast', 'category' => 'Restaurant', 'price' => 38.00, 'description' => 'Hot and cold buffet with live cooking station.'],
            ['name' => 'Three-Course Dinner', 'category' => 'Restaurant', 'price' => 85.00, 'description' => 'Chef\'s tasting menu in the sea-view restaurant.'],
            ['name' => 'Room Service - Breakfast', 'category' => 'Room Service', 'price' => 28.00, 'description' => 'Breakfast delivered to your room.'],
            ['name' => 'Room Service - Dinner', 'category' => 'Room Service', 'price' => 95.00, 'description' => 'Full dinner served in-suite.'],
            ['name' => 'Afternoon Tea', 'category' => 'Room Service', 'price' => 45.00, 'description' => 'Selection of teas, sandwiches and pastries.'],
            ['name' => 'Spa - Swedish Massage (60 min)', 'category' => 'Spa', 'price' => 120.00, 'description' => 'Relaxing full-body massage.'],
            ['name' => 'Spa - Hot Stone Massage (75 min)', 'category' => 'Spa', 'price' => 150.00, 'description' => 'Warm basalt stones and deep tissue work.'],
            ['name' => 'Spa - Facial Treatment', 'category' => 'Spa', 'price' => 90.00, 'description' => 'Rejuvenating facial with premium products.'],
            ['name' => 'Laundry - Express (24h)', 'category' => 'Laundry', 'price' => 18.00, 'description' => 'Wash, dry and press.'],
            ['name' => 'Laundry - Dry Cleaning', 'category' => 'Laundry', 'price' => 25.00, 'description' => 'Professional garment care.'],
            ['name' => 'Minibar - Standard', 'category' => 'Minibar', 'price' => 15.00, 'description' => 'Restocked minibar daily.'],
            ['name' => 'Minibar - Premium', 'category' => 'Minibar', 'price' => 30.00, 'description' => 'Premium drinks and snacks.'],
            ['name' => 'Airport Transfer', 'category' => 'Other', 'price' => 65.00, 'description' => 'Private sedan to/from the airport.'],
            ['name' => 'City Tour - Half Day', 'category' => 'Other', 'price' => 75.00, 'description' => 'Guided tour of the city with a driver.'],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['name' => $service['name']],
                $service + ['status' => 'active'],
            );
        }
    }
}
