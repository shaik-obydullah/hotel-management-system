<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Hotel Administrator', 'password' => 'password'],
        );
        $admin->syncRoles(['admin']);

        $staff = User::query()->firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Front Desk Agent', 'password' => 'password'],
        );
        $staff->syncRoles(['staff']);

        $housekeeper = User::query()->firstOrCreate(
            ['email' => 'housekeeping@example.com'],
            ['name' => 'Head Housekeeper', 'password' => 'password'],
        );
        $housekeeper->syncRoles(['staff']);
    }
}
