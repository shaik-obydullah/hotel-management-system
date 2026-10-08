<?php

namespace Database\Seeders;

use App\Models\HousekeepingTask;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class HousekeepingSeeder extends Seeder
{
    public function run(): void
    {
        $housekeeper = User::query()->where('email', 'housekeeping@example.com')->first();
        $admin = User::query()->where('email', 'admin@example.com')->first();
        $rooms = Room::query()->pluck('id');
        $today = CarbonImmutable::today();

        $cleaningRoomIds = $rooms->random(4);
        Room::query()->whereIn('id', $cleaningRoomIds)->update(['status' => 'cleaning']);

        foreach ($cleaningRoomIds as $roomId) {
            HousekeepingTask::create([
                'room_id' => $roomId,
                'task_type' => 'cleaning',
                'priority' => 'medium',
                'status' => 'pending',
                'assigned_to' => $housekeeper?->id,
                'scheduled_date' => $today->toDateString(),
                'notes' => 'Full clean after guest check-out.',
            ]);
        }

        $completed = $rooms->diff($cleaningRoomIds)->take(6);
        foreach ($completed as $roomId) {
            HousekeepingTask::create([
                'room_id' => $roomId,
                'task_type' => random_int(0, 1) ? 'cleaning' : 'deep-clean',
                'priority' => random_int(0, 1) ? 'low' : 'medium',
                'status' => 'completed',
                'assigned_to' => $housekeeper?->id,
                'scheduled_date' => $today->subDays(random_int(1, 10))->toDateString(),
                'completed_at' => CarbonImmutable::now()->subDays(random_int(1, 10))->subHours(random_int(1, 6)),
            ]);
        }

        $inProgress = $cleaningRoomIds->take(1);
        foreach ($inProgress as $roomId) {
            HousekeepingTask::create([
                'room_id' => $roomId,
                'task_type' => 'cleaning',
                'priority' => 'high',
                'status' => 'in-progress',
                'assigned_to' => $housekeeper?->id,
                'scheduled_date' => $today->toDateString(),
                'notes' => 'Urgent turnaround for afternoon arrival.',
            ]);
        }

        $maintenanceRooms = Room::query()->where('status', 'maintenance')->pluck('id');
        foreach ($maintenanceRooms as $roomId) {
            MaintenanceRequest::create([
                'room_id' => $roomId,
                'title' => 'Air conditioning not cooling',
                'description' => 'Guest reported the AC unit blowing warm air. Technician required.',
                'priority' => 'high',
                'status' => 'open',
                'reported_by' => $admin?->id,
                'assigned_to' => null,
            ]);
        }

        MaintenanceRequest::create([
            'room_id' => $rooms->random(),
            'title' => 'Leaking tap in bathroom',
            'description' => 'Minor leak under the sink. Needs a plumber visit.',
            'priority' => 'low',
            'status' => 'open',
            'reported_by' => $housekeeper?->id,
        ]);
    }
}
