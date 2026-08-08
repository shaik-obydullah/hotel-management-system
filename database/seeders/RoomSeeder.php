<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $floorNumbers = Floor::query()->orderBy('number')->pluck('number')->all();
        $types = RoomType::query()->orderBy('base_price')->get();
        $countPerFloor = 5;

        $rooms = [];
        foreach ($floorNumbers as $floorNumber) {
            foreach (range(1, $countPerFloor) as $index) {
                $roomType = $types[$index - 1 >= count($types) ? count($types) - 1 : ($index - 1) % count($types)];

                $rooms[] = [
                    'room_number' => sprintf('%d%02d', $floorNumber, $index),
                    'room_type_id' => $roomType->id,
                    'floor_id' => Floor::query()->where('number', $floorNumber)->value('id'),
                ];
            }
        }

        foreach ($rooms as $room) {
            Room::query()->firstOrCreate(['room_number' => $room['room_number']], $room);
        }
    }
}
