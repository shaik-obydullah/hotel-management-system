<?php

namespace App\Livewire\Admin;

use App\Enums\RoomStatus;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

#[Layout('layouts.admin')]
#[Title('Rooms')]
class Rooms extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $floorFilter = '';
    public string $typeFilter = '';

    public bool $showModal = false;
    public ?int $editingId = null;
    public string $room_number = '';
    public string $room_type_id = '';
    public string $floor_id = '';
    public string $status = 'available';
    public string $notes = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'room_number', 'room_type_id', 'floor_id', 'notes']);
        $this->status = RoomStatus::Available->value;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $room = Room::findOrFail($id);
        $this->editingId = $room->id;
        $this->room_number = $room->room_number;
        $this->room_type_id = (string) $room->room_type_id;
        $this->floor_id = (string) $room->floor_id;
        $this->status = $room->status->value;
        $this->notes = $room->notes ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'room_number' => ['required', 'string', 'max:20', 'unique:rooms,room_number,'.$this->editingId],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'floor_id' => ['required', 'exists:floors,id'],
            'status' => ['required', Rule::enum(RoomStatus::class)],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        Room::updateOrCreate(
            ['id' => $this->editingId],
            [
                'room_number' => $this->room_number,
                'room_type_id' => $this->room_type_id,
                'floor_id' => $this->floor_id,
                'status' => $this->status,
                'notes' => $this->notes ?: null,
            ],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Room updated.' : 'Room created.');
    }

    public function setStatus(int $id, string $status): void
    {
        Room::where('id', $id)->update(['status' => $status]);
    }

    public function delete(int $id): void
    {
        Room::findOrFail($id)->delete();
        session()->flash('message', 'Room deleted.');
    }

    #[Computed]
    public function rooms()
    {
        return Room::query()
            ->with(['roomType', 'floor'])
            ->when($this->search, fn ($q) => $q->where('room_number', 'like', '%'.$this->search.'%'))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->floorFilter, fn ($q) => $q->where('floor_id', $this->floorFilter))
            ->when($this->typeFilter, fn ($q) => $q->where('room_type_id', $this->typeFilter))
            ->orderBy('room_number')
            ->paginate(12);
    }

    #[Computed]
    public function roomTypes()
    {
        return RoomType::query()->orderBy('name')->get();
    }

    #[Computed]
    public function floors()
    {
        return Floor::query()->orderBy('number')->get();
    }

    public function render()
    {
        return view('livewire.admin.rooms');
    }
}
