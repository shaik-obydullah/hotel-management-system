<?php

namespace App\Livewire\Public;

use App\Models\HotelInfo;
use App\Models\RoomType;
use App\Services\BookingService;
use App\Services\RoomService;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Book Your Stay')]
class PublicBooking extends Component
{
    #[Url]
    public ?string $check_in = null;

    #[Url]
    public ?string $check_out = null;

    #[Url(as: 'room_type')]
    public ?string $room_type = null;

    #[Url(as: 'adults')]
    public int $adults = 2;

    #[Url(as: 'children')]
    public int $children = 0;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $nationality = '';
    public string $special_requests = '';
    public string $id_type = '';
    public string $id_number = '';

    public bool $unavailable = false;

    public function mount(): void
    {
        if (! $this->check_in) {
            $this->check_in = CarbonImmutable::today()->addDay()->toDateString();
        }
        if (! $this->check_out) {
            $this->check_out = CarbonImmutable::today()->addDays(3)->toDateString();
        }
        if (! $this->room_type) {
            $this->unavailable = true;
        }
    }

    #[Computed]
    public function roomType(): ?RoomType
    {
        return RoomType::query()->where('status', 'active')->find($this->room_type);
    }

    #[Computed]
    public function rates(): array
    {
        $type = $this->roomType;
        if (! $type) {
            return [];
        }

        return app(RoomService::class)->nightlyRatesForRange($type, $this->check_in, $this->check_out);
    }

    #[Computed]
    public function price(): array
    {
        $type = $this->roomType;
        if (! $type || $this->unavailable) {
            return ['subtotal' => 0, 'discount' => 0, 'tax' => 0, 'total' => 0, 'nights' => 0];
        }

        return app(BookingService::class)->calculatePrice($type, $this->check_in, $this->check_out);
    }

    #[Computed]
    public function taxRate(): float
    {
        return (float) HotelInfo::current()->tax_rate;
    }

    public function submit(BookingService $bookingService, RoomService $roomService): void
    {
        $this->validate();

        $room = $roomService->availableRooms($this->check_in, $this->check_out, $this->room_type)->first();

        if (! $room) {
            $this->addError('room_type', 'Sorry, this room type is no longer available for the selected dates.');

            return;
        }

        try {
            $booking = $bookingService->createBooking([
                'room_id' => $room->id,
                'check_in_date' => $this->check_in,
                'check_out_date' => $this->check_out,
                'adults' => $this->adults,
                'children' => $this->children,
                'special_requests' => $this->special_requests ?: null,
                'source' => 'online',
                'guest' => [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'nationality' => $this->nationality ?: null,
                    'id_type' => $this->id_type ?: null,
                    'id_number' => $this->id_number ?: null,
                ],
            ]);

            $this->redirect(route('booking.show', $booking->booking_number));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('room_type', 'Sorry, this room type is no longer available for the selected dates.');
        }
    }

    public function rules(): array
    {
        $maxGuests = $this->roomType?->max_guests ?? 6;

        return [
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:10'],
            'children' => ['required', 'integer', 'min:0', 'max:10'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'nationality' => ['nullable', 'string', 'max:80'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function render()
    {
        return view('livewire.public.public-booking');
    }
}
