<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class RoomService
{
    /**
     * Rooms not blocked by active bookings or maintenance for the given range.
     */
    public function availableRooms(CarbonImmutable|string $checkIn, CarbonImmutable|string $checkOut, ?int $roomTypeId = null): Collection
    {
        $checkIn = CarbonImmutable::parse($checkIn);
        $checkOut = CarbonImmutable::parse($checkOut);

        if ($checkOut->lte($checkIn)) {
            return collect();
        }

        $query = Room::query()
            ->whereIn('status', [RoomStatus::Available->value, RoomStatus::Cleaning->value]);

        if ($roomTypeId) {
            $query->where('room_type_id', $roomTypeId);
        }

        $rooms = $query->with('roomType', 'floor')->get();

        $blockedRoomIds = Booking::query()
            ->whereIn('room_id', $rooms->pluck('id'))
            ->where('status', '!=', BookingStatus::Cancelled->value)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<', $checkOut->toDateString())
                    ->where('check_out_date', '>', $checkIn->toDateString());
            })
            ->pluck('room_id');

        return $rooms->whereNotIn('id', $blockedRoomIds)->values();
    }

    /**
     * Per room-type availability summary used by the public availability page.
     */
    public function availabilitySummary(CarbonImmutable|string $checkIn, CarbonImmutable|string $checkOut): Collection
    {
        $checkIn = CarbonImmutable::parse($checkIn);
        $checkOut = CarbonImmutable::parse($checkOut);
        $nights = max(1, (int) $checkIn->diffInDays($checkOut));

        return RoomType::query()
            ->where('status', 'active')
            ->withCount(['rooms as total_rooms'])
            ->get()
            ->map(function (RoomType $type) use ($checkIn, $checkOut, $nights) {
                $available = $this->availableRooms($checkIn, $checkOut, $type->id)->count();
                $rate = $this->nightlyRate($type, $checkIn);

                return (object) [
                    'room_type' => $type,
                    'available' => $available,
                    'total' => $type->total_rooms,
                    'rate' => $rate,
                    'nights' => $nights,
                    'subtotal' => $rate * $nights,
                ];
            })
            ->filter(fn ($item) => $item->available > 0 || $item->total > 0)
            ->values();
    }

    public function nightlyRate(RoomType $roomType, CarbonImmutable|string $date): float
    {
        $date = CarbonImmutable::parse($date);

        $seasonal = $roomType->seasonalRates()
            ->where('status', 'active')
            ->whereDate('start_date', '<=', $date->toDateString())
            ->whereDate('end_date', '>=', $date->toDateString())
            ->orderByDesc('price')
            ->first();

        return $seasonal ? (float) $seasonal->price : (float) $roomType->base_price;
    }

    public function nightlyRatesForRange(RoomType $roomType, CarbonImmutable|string $checkIn, CarbonImmutable|string $checkOut): array
    {
        $checkIn = CarbonImmutable::parse($checkIn);
        $checkOut = CarbonImmutable::parse($checkOut);
        $rates = [];

        for ($date = $checkIn; $date->lt($checkOut); $date = $date->addDay()) {
            $rates[$date->toDateString()] = $this->nightlyRate($roomType, $date);
        }

        return $rates;
    }

    public function isAvailable(Room $room, CarbonImmutable|string $checkIn, CarbonImmutable|string $checkOut): bool
    {
        return $this->availableRooms($checkIn, $checkOut, $room->room_type_id)
            ->contains('id', $room->id);
    }
}
