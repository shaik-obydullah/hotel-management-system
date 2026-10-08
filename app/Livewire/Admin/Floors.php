<?php

namespace App\Livewire\Admin;

use App\Models\Floor;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Floors')]
class Floors extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public int $number = 0;

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name']);
        $this->number = (int) (Floor::query()->max('number') ?? 0) + 1;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $floor = Floor::findOrFail($id);
        $this->editingId = $floor->id;
        $this->name = $floor->name;
        $this->number = $floor->number;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:80'],
            'number' => ['required', 'integer', 'min:0', 'max:200'],
        ]);

        Floor::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->name, 'number' => $this->number],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Floor updated.' : 'Floor created.');
    }

    public function delete(int $id): void
    {
        Floor::findOrFail($id)->delete();
        session()->flash('message', 'Floor deleted.');
    }

    #[Computed]
    public function floors()
    {
        return Floor::query()->withCount('rooms')->orderBy('number')->get();
    }

    public function render()
    {
        return view('livewire.admin.floors');
    }
}
