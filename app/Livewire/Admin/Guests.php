<?php

namespace App\Livewire\Admin;

use App\Models\Guest;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Guests')]
class Guests extends Component
{
    use WithPagination;

    public string $search = '';
    public string $vipFilter = '';

    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $nationality = '';
    public string $id_type = '';
    public string $id_number = '';
    public string $address = '';
    public string $city = '';
    public string $country = '';
    public bool $vip_status = false;
    public string $notes = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone', 'nationality', 'id_type', 'id_number', 'address', 'city', 'country', 'notes']);
        $this->vip_status = false;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $guest = Guest::findOrFail($id);
        $this->editingId = $guest->id;
        $this->name = $guest->name;
        $this->email = $guest->email ?? '';
        $this->phone = $guest->phone ?? '';
        $this->nationality = $guest->nationality ?? '';
        $this->id_type = $guest->id_type ?? '';
        $this->id_number = $guest->id_number ?? '';
        $this->address = $guest->address ?? '';
        $this->city = $guest->city ?? '';
        $this->country = $guest->country ?? '';
        $this->vip_status = $guest->vip_status;
        $this->notes = $guest->notes ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'nationality' => ['nullable', 'string', 'max:80'],
            'id_type' => ['nullable', 'string', 'max:40'],
            'id_number' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80'],
            'country' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Guest::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'email' => $this->email ?: null,
                'phone' => $this->phone,
                'nationality' => $this->nationality ?: null,
                'id_type' => $this->id_type ?: null,
                'id_number' => $this->id_number ?: null,
                'address' => $this->address ?: null,
                'city' => $this->city ?: null,
                'country' => $this->country ?: null,
                'vip_status' => $this->vip_status,
                'notes' => $this->notes ?: null,
            ],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Guest updated.' : 'Guest created.');
    }

    public function toggleVip(int $id): void
    {
        $guest = Guest::findOrFail($id);
        $guest->update(['vip_status' => ! $guest->vip_status]);
    }

    public function delete(int $id): void
    {
        Guest::findOrFail($id)->delete();
        session()->flash('message', 'Guest deleted.');
    }

    #[Computed]
    public function guests()
    {
        return Guest::query()
            ->withCount('bookings')
            ->when($this->search, function ($q) {
                $q->where(fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%')
                    ->orWhere('id_number', 'like', '%'.$this->search.'%'));
            })
            ->when($this->vipFilter, fn ($q) => $q->where('vip_status', $this->vipFilter === 'vip'))
            ->orderBy('name')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.guests');
    }
}
