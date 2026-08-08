<?php

namespace App\Livewire\Admin;

use App\Models\Guest;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Guest Profile')]
class GuestDetail extends Component
{
    public Guest $guest;

    public function mount(Guest $guest): void
    {
        $this->guest = $guest->load('preferences');
    }

    #[Computed]
    public function bookings()
    {
        return $this->guest->bookings()
            ->with(['room.roomType', 'invoice'])
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.guest-detail');
    }
}
