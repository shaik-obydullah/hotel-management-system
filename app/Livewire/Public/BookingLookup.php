<?php

namespace App\Livewire\Public;

use App\Models\Booking;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Find My Booking')]
class BookingLookup extends Component
{
    public string $booking_number = '';
    public string $email = '';

    public ?Booking $result = null;
    public bool $searched = false;
    public ?string $error = null;

    public function search(): void
    {
        $this->validate([
            'booking_number' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $this->result = Booking::query()
            ->with(['guest', 'room.roomType'])
            ->where('booking_number', $this->booking_number)
            ->whereHas('guest', fn ($q) => $q->whereRaw('LOWER(email) = ?', [strtolower($this->email)]))
            ->first();

        $this->searched = true;
        $this->error = $this->result ? null : 'No booking found with that number and email combination.';
    }

    public function render()
    {
        return view('livewire.public.booking-lookup');
    }
}
