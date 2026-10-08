<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Services')]
class Services extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $category = 'Room Service';
    public string $price = '';
    public string $description = '';
    public string $status = 'active';

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'price']);
        $this->category = 'Room Service';
        $this->status = 'active';
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $service = Service::findOrFail($id);
        $this->editingId = $service->id;
        $this->name = $service->name;
        $this->category = $service->category;
        $this->price = (string) $service->price;
        $this->description = $service->description ?? '';
        $this->status = $service->status;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:40'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Service::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'category' => $this->category,
                'price' => $this->price,
                'description' => $this->description ?: null,
                'status' => $this->status,
            ],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Service updated.' : 'Service created.');
    }

    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        session()->flash('message', 'Service deleted.');
    }

    #[Computed]
    public function services()
    {
        return Service::query()->orderBy('category')->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.services');
    }
}
