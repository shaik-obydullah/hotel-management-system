<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Booking Calendar')]
class BookingCalendar extends Component
{
    public string $month;

    public function mount(): void
    {
        $this->month = now()->format('Y-m');
    }

    public function prevMonth(): void
    {
        $this->month = CarbonImmutable::parse($this->month.'-01')->subMonth()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->month = CarbonImmutable::parse($this->month.'-01')->addMonth()->format('Y-m');
    }

    public function goToday(): void
    {
        $this->month = now()->format('Y-m');
    }

    public function render()
    {
        $start = CarbonImmutable::parse($this->month.'-01')->startOfMonth();
        $end = $start->endOfMonth();
        $startWeekday = $start->dayOfWeek; // 0 = Sunday

        $days = collect();
        for ($date = $start; $date->lte($end); $date = $date->addDay()) {
            $days->push($date);
        }

        $bookings = Booking::query()
            ->with(['guest', 'room'])
            ->where('status', '!=', BookingStatus::Cancelled->value)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('check_in_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('check_out_date', [$start->toDateString(), $end->toDateString()]);
            })
            ->get();

        return view('livewire.admin.booking-calendar', [
            'start' => $start,
            'end' => $end,
            'startWeekday' => $startWeekday,
            'days' => $days,
            'bookings' => $bookings,
        ]);
    }
}
