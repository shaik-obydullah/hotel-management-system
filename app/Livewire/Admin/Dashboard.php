<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\ReportService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    #[Computed]
    public function stats(): array
    {
        return app(ReportService::class)->dashboardStats();
    }

    #[Computed]
    public function recentBookings()
    {
        return Booking::query()
            ->with(['guest', 'room.roomType'])
            ->latest()
            ->limit(8)
            ->get();
    }

    #[Computed]
    public function arrivalsToday()
    {
        return Booking::query()
            ->with(['guest', 'room'])
            ->whereDate('check_in_date', now()->toDateString())
            ->where('status', '!=', BookingStatus::Cancelled->value)
            ->get();
    }

    #[Computed]
    public function departuresToday()
    {
        return Booking::query()
            ->with(['guest', 'room'])
            ->whereDate('check_out_date', now()->toDateString())
            ->where('status', '!=', BookingStatus::Cancelled->value)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
