<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Standard Single',
                'description' => 'Compact and comfortable room with a single bed, ideal for solo travellers.',
                'base_price' => 120.00,
                'max_guests' => 1,
                'size_sqft' => 280,
                'bed_type' => 'Single bed',
                'amenities' => ['Free Wi-Fi', 'Smart TV', 'Air conditioning', 'Coffee maker', 'Work desk'],
            ],
            [
                'name' => 'Deluxe Double',
                'description' => 'Spacious double room with city views and a king-size bed.',
                'base_price' => 180.00,
                'max_guests' => 2,
                'size_sqft' => 380,
                'bed_type' => 'King bed',
                'amenities' => ['Free Wi-Fi', 'Smart TV', 'Air conditioning', 'Mini bar', 'Coffee maker', 'Safe', 'Work desk'],
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Elegant suite with a separate living area and panoramic sea views.',
                'base_price' => 320.00,
                'max_guests' => 3,
                'size_sqft' => 620,
                'bed_type' => 'King bed + sofa bed',
                'amenities' => ['Free Wi-Fi', 'Smart TV', 'Air conditioning', 'Mini bar', 'Coffee maker', 'Safe', 'Bathrobe & slippers', 'Lounge access'],
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Our largest suite with a private terrace, dining room and butler service.',
                'base_price' => 640.00,
                'max_guests' => 4,
                'size_sqft' => 1200,
                'bed_type' => '2 King beds',
                'amenities' => ['Free Wi-Fi', 'Smart TV', 'Air conditioning', 'Mini bar', 'Private terrace', 'Butler service', 'Jacuzzi', 'Lounge access', 'Chauffeur'],
            ],
        ];

        foreach ($types as $type) {
            RoomType::query()->updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                $type + ['status' => 'active'],
            );
        }
    }
}
