<?php

namespace Database\Seeders;

use App\Models\HotelInfo;
use Illuminate\Database\Seeder;

class HotelInfoSeeder extends Seeder
{
    public function run(): void
    {
        HotelInfo::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Grand Azure Hotel',
                'tagline' => 'Where luxury meets the sea',
                'address' => '12 Marina Bay Drive',
                'city' => 'Dubai',
                'country' => 'United Arab Emirates',
                'phone' => '+971 4 555 0100',
                'email' => 'reservations@grandazure.example',
                'check_in_time' => '14:00',
                'check_out_time' => '11:00',
                'currency' => 'USD',
                'tax_rate' => 10.00,
                'description' => 'A five-star seaside retreat offering panoramic ocean views, world-class dining and impeccable service. Our 24 rooms and suites blend modern comfort with timeless elegance.',
            ],
        );
    }
}
