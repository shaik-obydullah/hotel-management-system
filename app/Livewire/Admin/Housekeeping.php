<?php

namespace App\Livewire\Admin;

use App\Models\HousekeepingTask;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Housekeeping')]
class Housekeeping extends Component
{
    use WithPagination;

    public string $tab = 'tasks';

    public bool $showTaskModal = false;
    public string $task_room_id = '';
    public string $task_type = 'cleaning';
    public string $task_priority = 'medium';
    public string $task_status = 'pending';
    public string $task_assignee = '';
    public string $task_date = '';
    public string $task_notes = '';

    public bool $showMaintenanceModal = false;
    public string $maint_room_id = '';
    public string $maint_title = '';
    public string $maint_description = '';
    public string $maint_priority = 'medium';
    public string $maint_status = 'open';

    public function createTask(): void
    {
        $this->validate([
            'task_room_id' => ['required', 'exists:rooms,id'],
            'task_type' => ['required', 'string'],
            'task_priority' => ['required', 'in:low,medium,high'],
            'task_status' => ['required', 'in:pending,in-progress,completed'],
            'task_assignee' => ['nullable', 'exists:users,id'],
            'task_date' => ['nullable', 'date'],
            'task_notes' => ['nullable', 'string', 'max:500'],
        ]);

        HousekeepingTask::create([
            'room_id' => $this->task_room_id,
            'task_type' => $this->task_type,
            'priority' => $this->task_priority,
            'status' => $this->task_status,
            'assigned_to' => $this->task_assignee ?: null,
            'scheduled_date' => $this->task_date ?: null,
            'notes' => $this->task_notes ?: null,
        ]);

        $this->reset(['task_room_id', 'task_notes']);
        $this->showTaskModal = false;
        session()->flash('message', 'Housekeeping task created.');
    }

    public function completeTask(int $id): void
    {
        HousekeepingTask::where('id', $id)->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        session()->flash('message', 'Task marked complete.');
    }

    public function deleteTask(int $id): void
    {
        HousekeepingTask::findOrFail($id)->delete();
        session()->flash('message', 'Task deleted.');
    }

    public function createMaintenance(): void
    {
        $this->validate([
            'maint_room_id' => ['required', 'exists:rooms,id'],
            'maint_title' => ['required', 'string', 'max:120'],
            'maint_description' => ['nullable', 'string', 'max:1000'],
            'maint_priority' => ['required', 'in:low,medium,high'],
            'maint_status' => ['required', 'in:open,in-progress,resolved'],
        ]);

        MaintenanceRequest::create([
            'room_id' => $this->maint_room_id,
            'title' => $this->maint_title,
            'description' => $this->maint_description ?: null,
            'priority' => $this->maint_priority,
            'status' => $this->maint_status,
            'reported_by' => auth()->id(),
        ]);

        $this->reset(['maint_room_id', 'maint_title', 'maint_description']);
        $this->showMaintenanceModal = false;
        session()->flash('message', 'Maintenance request created.');
    }

    public function updateMaintenanceStatus(int $id, string $status): void
    {
        MaintenanceRequest::where('id', $id)->update([
            'status' => $status,
            'resolved_at' => $status === 'resolved' ? now() : null,
        ]);
        session()->flash('message', 'Maintenance request updated.');
    }

    #[Computed]
    public function tasks()
    {
        return HousekeepingTask::query()
            ->with(['room.roomType', 'assignee'])
            ->orderByRaw("FIELD(status, 'pending', 'in-progress', 'completed')")
            ->orderByDesc('scheduled_date')
            ->paginate(12);
    }

    #[Computed]
    public function maintenanceRequests()
    {
        return MaintenanceRequest::query()
            ->with(['room', 'reporter'])
            ->orderByRaw("FIELD(status, 'open', 'in-progress', 'resolved')")
            ->latest()
            ->paginate(12);
    }

    #[Computed]
    public function rooms()
    {
        return Room::query()->with('roomType')->orderBy('room_number')->get();
    }

    #[Computed]
    public function staffUsers()
    {
        return User::query()->whereHas('roles', fn ($q) => $q->whereIn('name', ['admin', 'staff']))->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.housekeeping');
    }
}
