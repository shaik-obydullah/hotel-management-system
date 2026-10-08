<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Room Types')]
class RoomTypes extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $description = '';
    public string $base_price = '';
    public int $max_guests = 2;
    public string $size_sqft = '';
    public string $bed_type = '';
    public string $amenities = '';
    public string $status = 'active';

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'base_price', 'size_sqft', 'bed_type', 'amenities']);
        $this->max_guests = 2;
        $this->status = 'active';
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $type = RoomType::findOrFail($id);
        $this->editingId = $type->id;
        $this->name = $type->name;
        $this->description = $type->description ?? '';
        $this->base_price = (string) $type->base_price;
        $this->max_guests = $type->max_guests;
        $this->size_sqft = (string) ($type->size_sqft ?? '');
        $this->bed_type = $type->bed_type ?? '';
        $this->amenities = implode(', ', $type->amenities ?? []);
        $this->status = $type->status;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:80'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'max_guests' => ['required', 'integer', 'min:1', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
            'size_sqft' => ['nullable', 'numeric', 'min:0'],
            'bed_type' => ['nullable', 'string', 'max:80'],
            'amenities' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $amenities = array_values(array_filter(array_map('trim', explode(',', $this->amenities))));

        RoomType::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name).'-'.$this->editingId ?? Str::slug($this->name).'-'.random_int(10, 99),
                'description' => $this->description ?: null,
                'base_price' => $this->base_price,
                'max_guests' => $this->max_guests,
                'size_sqft' => $this->size_sqft ?: null,
                'bed_type' => $this->bed_type ?: null,
                'amenities' => $amenities,
                'status' => $this->status,
            ],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Room type updated.' : 'Room type created.');
    }

    public function delete(int $id): void
    {
        RoomType::findOrFail($id)->delete();
        session()->flash('message', 'Room type deleted.');
    }

    #[Computed]
    public function roomTypes()
    {
        return RoomType::query()->withCount('rooms')->orderBy('base_price')->get();
    }

    public function render()
    {
        return view('livewire.admin.room-types');
    }
}
