<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            HotelInfoSeeder::class,
            FloorSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            GuestSeeder::class,
            ServiceSeeder::class,
            StaffSeeder::class,
            BookingSeeder::class,
            HousekeepingSeeder::class,
        ]);
    }
}
