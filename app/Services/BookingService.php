<?php

namespace App\Services;

use App\Enums\BookingSource;
use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Guest;
use App\Models\HotelInfo;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class BookingService
{
    public function __construct(
        protected RoomService $roomService,
        protected BillingService $billingService,
    ) {
    }

    public function generateBookingNumber(): string
    {
        return 'GAZ-'.now()->format('Ymd').'-'.strtoupper(random_int(1000, 9999));
    }

    /**
     * Price breakdown for a room type over a date range.
     *
     * @return array{subtotal: float, discount: float, tax: float, total: float, rates: array}
     */
    public function calculatePrice(RoomType|Room $room, CarbonImmutable|string $checkIn, CarbonImmutable|string $checkOut, float $discountAmount = 0): array
    {
        $roomType = $room instanceof Room ? $room->roomType : $room;
        $checkIn = CarbonImmutable::parse($checkIn);
        $checkOut = CarbonImmutable::parse($checkOut);
        $taxRate = (float) HotelInfo::current()->tax_rate;

        $rates = $this->roomService->nightlyRatesForRange($roomType, $checkIn, $checkOut);
        $nights = count($rates);
        $subtotal = array_sum($rates);
        $discount = min($discountAmount, $subtotal);
        $tax = round(($subtotal - $discount) * ($taxRate / 100), 2);
        $total = round($subtotal - $discount + $tax, 2);

        return compact('subtotal', 'discount', 'tax', 'total', 'nights', 'rates');
    }

    /**
     * Create a booking. Throws ValidationException when the room is not available.
     */
    public function createBooking(array $data, ?User $actor = null): Booking
    {
        $checkIn = CarbonImmutable::parse($data['check_in_date']);
        $checkOut = CarbonImmutable::parse($data['check_out_date']);
        $room = Room::with('roomType')->findOrFail($data['room_id']);

        if (!$this->roomService->isAvailable($room, $checkIn, $checkOut)) {
            throw ValidationException::withMessages([
                'room_id' => 'This room is no longer available for the selected dates.',
            ]);
        }

        $price = $this->calculatePrice($room, $checkIn, $checkOut, (float) ($data['discount'] ?? 0));

        $guest = isset($data['guest_id'])
            ? Guest::findOrFail($data['guest_id'])
            : $this->findOrCreateGuest($data['guest'] ?? []);

        $booking = DB::transaction(function () use ($data, $room, $guest, $checkIn, $checkOut, $price, $actor) {
            $booking = Booking::create([
                'booking_number' => $this->generateBookingNumber(),
                'guest_id' => $guest->id,
                'room_id' => $room->id,
                'check_in_date' => $checkIn->toDateString(),
                'check_out_date' => $checkOut->toDateString(),
                'adults' => $data['adults'] ?? 1,
                'children' => $data['children'] ?? 0,
                'status' => $data['status'] ?? BookingStatus::Confirmed,
                'source' => $data['source'] ?? BookingSource::Online,
                'special_requests' => $data['special_requests'] ?? null,
                'room_rate' => $price['rates'][$checkIn->toDateString()] ?? $price['subtotal'] / max(1, $price['nights']),
                'nights' => $price['nights'],
                'subtotal' => $price['subtotal'],
                'discount' => $price['discount'],
                'tax' => $price['tax'],
                'total_amount' => $price['total'],
                'paid_amount' => 0,
                'created_by' => $actor?->id,
            ]);

            $this->logStatus($booking, $booking->status, $actor, 'Booking created');

            return $booking;
        });

        if (($data['source'] ?? '') !== BookingSource::Online->value) {
            $room->update(['status' => RoomStatus::Occupied->value]);
        }

        return $booking->load('guest', 'room.roomType');
    }

    public function checkIn(Booking $booking, ?User $actor = null, ?string $notes = null): Booking
    {
        $booking->update(['status' => BookingStatus::CheckedIn]);
        $booking->room()->update(['status' => RoomStatus::Occupied->value]);
        $this->logStatus($booking, BookingStatus::CheckedIn, $actor, $notes ?? 'Guest checked in');

        return $booking;
    }

    public function checkOut(Booking $booking, ?User $actor = null, ?string $notes = null): Booking
    {
        $booking->update(['status' => BookingStatus::CheckedOut]);
        $booking->room()->update(['status' => RoomStatus::Cleaning->value]);
        $this->logStatus($booking, BookingStatus::CheckedOut, $actor, $notes ?? 'Guest checked out');

        $this->billingService->generateInvoiceForBooking($booking);

        return $booking;
    }

    public function cancel(Booking $booking, ?User $actor = null, ?string $reason = null): Booking
    {
        $booking->update([
            'status' => BookingStatus::Cancelled,
            'special_requests' => $reason ? ($booking->special_requests ? $booking->special_requests."\n[Cancellation] {$reason}" : "[Cancellation] {$reason}") : $booking->special_requests,
        ]);

        if ($booking->room->status === RoomStatus::Occupied) {
            $booking->room()->update(['status' => RoomStatus::Available->value]);
        }

        $this->logStatus($booking, BookingStatus::Cancelled, $actor, $reason ?? 'Booking cancelled');

        return $booking;
    }

    public function confirm(Booking $booking, ?User $actor = null): Booking
    {
        $booking->update(['status' => BookingStatus::Confirmed]);
        $this->logStatus($booking, BookingStatus::Confirmed, $actor, 'Booking confirmed');

        return $booking;
    }

    public function findOrCreateGuest(array $data): Guest
    {
        $query = Guest::query();

        if (!empty($data['email'])) {
            $query->where('email', $data['email']);
        } elseif (!empty($data['phone'])) {
            $query->where('phone', $data['phone']);
        }

        $guest = $query->first();

        if ($guest) {
            $guest->update(array_filter([
                'name' => $data['name'] ?? $guest->name,
                'phone' => $data['phone'] ?? $guest->phone,
                'email' => $data['email'] ?? $guest->email,
                'nationality' => $data['nationality'] ?? $guest->nationality,
            ]));

            return $guest;
        }

        return Guest::create([
            'name' => $data['name'] ?? 'Guest',
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'id_type' => $data['id_type'] ?? null,
            'id_number' => $data['id_number'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
        ]);
    }

    protected function logStatus(Booking $booking, BookingStatus $status, ?User $actor, ?string $notes = null): void
    {
        BookingStatusHistory::create([
            'booking_id' => $booking->id,
            'status' => $status->value,
            'changed_by' => $actor?->id,
            'notes' => $notes,
        ]);
    }
}
