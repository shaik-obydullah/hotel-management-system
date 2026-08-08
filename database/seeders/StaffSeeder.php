<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->get();

        $staff = [
            ['admin@example.com', 'EMP-0001', 'General Manager', 'Management', 'Hotel Administrator'],
            ['staff@example.com', 'EMP-0002', 'Front Desk Agent', 'Front Office', 'Front Desk Agent'],
            ['housekeeping@example.com', 'EMP-0003', 'Head Housekeeper', 'Housekeeping', 'Head Housekeeper'],
            [null, 'EMP-0004', 'Chef de Cuisine', 'Restaurant', 'Marco Bellini'],
            [null, 'EMP-0005', 'Maintenance Technician', 'Maintenance', 'Ivan Petrov'],
            [null, 'EMP-0006', 'Spa Therapist', 'Spa', 'Lina Garcia'],
            [null, 'EMP-0007', 'Concierge', 'Front Office', 'Pierre Duval'],
            [null, 'EMP-0008', 'Night Auditor', 'Front Office', 'Sami Karim'],
        ];

        foreach ($staff as [$email, $employeeId, $role, $department, $name]) {
            $user = $email ? $users->firstWhere('email', $email) : null;

            Staff::query()->updateOrCreate(
                ['employee_id' => $employeeId],
                [
                    'user_id' => $user?->id,
                    'name' => $name,
                    'role' => $role,
                    'department' => $department,
                    'phone' => '+971 4 555 0'.str_pad((string) random_int(100, 999), 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                ],
            );
        }
    }
}
