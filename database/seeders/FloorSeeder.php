<?php

namespace Database\Seeders;

use App\Models\Floor;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $floors = [
            ['name' => 'Ground Floor', 'number' => 0],
            ['name' => 'First Floor', 'number' => 1],
            ['name' => 'Second Floor', 'number' => 2],
            ['name' => 'Third Floor', 'number' => 3],
            ['name' => 'Fourth Floor', 'number' => 4],
        ];

        foreach ($floors as $floor) {
            Floor::query()->firstOrCreate(['number' => $floor['number']], $floor);
        }
    }
}
