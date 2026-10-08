<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class ReportService
{
    public function occupancyForDate(CarbonImmutable|string $date): array
    {
        $date = CarbonImmutable::parse($date);
        $totalRooms = Room::query()->count();
        $occupiedRooms = Booking::query()
            ->where('check_in_date', '<=', $date->toDateString())
            ->where('check_out_date', '>', $date->toDateString())
            ->whereIn('status', [BookingStatus::Confirmed->value, BookingStatus::CheckedIn->value])
            ->count();

        return [
            'date' => $date,
            'total_rooms' => $totalRooms,
            'occupied' => $occupiedRooms,
            'available' => max(0, $totalRooms - $occupiedRooms),
            'rate' => $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0,
        ];
    }

    public function occupancyByMonth(int $year, int $month): array
    {
        $start = CarbonImmutable::create($year, $month, 1)->startOfDay();
        $end = $start->endOfMonth();
        $totalRooms = Room::query()->count();

        $data = [];
        for ($date = $start->copy(); $date->lte($end); $date = $date->addDay()) {
            $occupied = Booking::query()
                ->where('check_in_date', '<=', $date->toDateString())
                ->where('check_out_date', '>', $date->toDateString())
                ->whereIn('status', [BookingStatus::Confirmed->value, BookingStatus::CheckedIn->value])
                ->count();

            $data[] = [
                'date' => $date->format('Y-m-d'),
                'occupied' => $occupied,
                'rate' => $totalRooms > 0 ? round(($occupied / $totalRooms) * 100, 1) : 0,
            ];
        }

        return $data;
    }

    public function revenueByMonth(int $year): Collection
    {
        $rows = [];
        for ($month = 1; $month <= 12; $month++) {
            $rows[] = [
                'month' => CarbonImmutable::create($year, $month, 1),
                'label' => CarbonImmutable::create($year, $month, 1)->format('M'),
                'revenue' => round((float) Payment::query()
                    ->where('status', PaymentStatus::Completed->value)
                    ->whereYear('paid_at', $year)
                    ->whereMonth('paid_at', $month)
                    ->sum('amount'), 2),
            ];
        }

        return collect($rows);
    }

    public function dashboardStats(): array
    {
        $today = CarbonImmutable::today();
        $monthStart = $today->startOfMonth();
        $monthEnd = $today->endOfMonth();

        return [
            'occupancy' => $this->occupancyForDate($today),
            'arrivals_today' => Booking::query()
                ->whereDate('check_in_date', $today->toDateString())
                ->where('status', '!=', BookingStatus::Cancelled->value)
                ->count(),
            'departures_today' => Booking::query()
                ->whereDate('check_out_date', $today->toDateString())
                ->where('status', '!=', BookingStatus::Cancelled->value)
                ->count(),
            'active_bookings' => Booking::query()
                ->whereIn('status', [BookingStatus::Confirmed->value, BookingStatus::CheckedIn->value])
                ->count(),
            'monthly_revenue' => round((float) Payment::query()
                ->where('status', PaymentStatus::Completed->value)
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('amount'), 2),
            'monthly_bookings' => Booking::query()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count(),
            'total_guests' => \App\Models\Guest::query()->count(),
            'pending_invoices' => Invoice::query()
                ->where('status', '!=', 'paid')
                ->where('status', '!=', 'cancelled')
                ->count(),
        ];
    }
}
