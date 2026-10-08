<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Bookings')]
class Bookings extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $sourceFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'sourceFilter', 'dateFrom', 'dateTo']);
    }

    #[Computed]
    public function bookings()
    {
        return Booking::query()
            ->with(['guest', 'room.roomType'])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('booking_number', 'like', '%'.$this->search.'%')
                        ->orWhereHas('guest', fn ($g) => $g->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%')
                            ->orWhere('phone', 'like', '%'.$this->search.'%'));
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->sourceFilter, fn ($q) => $q->where('source', $this->sourceFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('check_in_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('check_in_date', '<=', $this->dateTo))
            ->latest()
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.bookings');
    }
}
