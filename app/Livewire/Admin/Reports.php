<?php

namespace App\Livewire\Admin;

use App\Enums\BookingStatus;
use App\Enums\BookingSource;
use App\Models\Booking;
use App\Services\ReportService;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Reports')]
class Reports extends Component
{
    public string $month;
    public int $year;

    public function mount(): void
    {
        $this->month = now()->format('Y-m');
        $this->year = now()->year;
    }

    #[Computed]
    public function occupancy()
    {
        $parts = explode('-', $this->month);

        return app(ReportService::class)->occupancyByMonth((int) $parts[0], (int) $parts[1]);
    }

    #[Computed]
    public function revenue()
    {
        return app(ReportService::class)->revenueByMonth($this->year);
    }

    #[Computed]
    public function avgOccupancy(): float
    {
        $data = collect($this->occupancy);
        if ($data->isEmpty()) {
            return 0;
        }

        return round($data->avg('rate'), 1);
    }

    #[Computed]
    public function maxRevenue(): float
    {
        return max(1, $this->revenue->max('revenue'));
    }

    #[Computed]
    public function statusBreakdown()
    {
        $total = Booking::query()->count();

        return collect(BookingStatus::cases())->map(function ($status) use ($total) {
            return [
                'status' => $status,
                'count' => Booking::query()->where('status', $status)->count(),
                'total' => $total,
            ];
        });
    }

    #[Computed]
    public function sourceBreakdown()
    {
        $total = Booking::query()->count();

        return collect(BookingSource::cases())->map(function ($source) use ($total) {
            return [
                'source' => $source,
                'count' => Booking::query()->where('source', $source)->count(),
                'total' => $total,
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.reports');
    }
}
