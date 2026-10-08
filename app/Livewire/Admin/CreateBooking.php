<?php

namespace App\Livewire\Admin;

use App\Models\Guest;
use App\Models\RoomType;
use App\Services\BookingService;
use App\Services\RoomService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('New Booking')]
class CreateBooking extends Component
{
    public string $check_in = '';
    public string $check_out = '';
    public int $adults = 2;
    public int $children = 0;
    public string $room_type_id = '';
    public string $room_id = '';
    public string $discount = '0';
    public string $special_requests = '';

    public ?int $guest_id = null;
    public string $guest_query = '';
    public bool $creatingGuest = false;

    public string $g_name = '';
    public string $g_email = '';
    public string $g_phone = '';
    public string $g_nationality = '';
    public string $g_id_type = '';
    public string $g_id_number = '';
    public string $g_address = '';
    public string $g_city = '';
    public string $g_country = '';

    public function mount(): void
    {
        $this->check_in = now()->toDateString();
        $this->check_out = now()->addDay()->toDateString();
    }

    public function updatedRoomTypeId(): void
    {
        $this->room_id = '';
    }

    public function updatedGuestQuery(): void
    {
        $this->guest_id = null;
    }

    public function selectGuest(int $id): void
    {
        $this->guest_id = $id;
        $this->guest_query = Guest::find($id)?->name ?? '';
        $this->creatingGuest = false;
    }

    public function changeGuest(): void
    {
        $this->guest_id = null;
        $this->guest_query = '';
    }

    public function createGuest(): void
    {
        $this->validate([
            'g_name' => ['required', 'string', 'max:120'],
            'g_email' => ['nullable', 'email', 'max:120'],
            'g_phone' => ['required', 'string', 'max:30'],
            'g_nationality' => ['nullable', 'string', 'max:80'],
        ]);

        $guest = Guest::create([
            'name' => $this->g_name,
            'email' => $this->g_email ?: null,
            'phone' => $this->g_phone,
            'nationality' => $this->g_nationality ?: null,
            'id_type' => $this->g_id_type ?: null,
            'id_number' => $this->g_id_number ?: null,
            'address' => $this->g_address ?: null,
            'city' => $this->g_city ?: null,
            'country' => $this->g_country ?: null,
        ]);

        $this->guest_id = $guest->id;
        $this->guest_query = $guest->name;
        $this->creatingGuest = false;
        $this->reset(['g_name', 'g_email', 'g_phone', 'g_nationality', 'g_id_type', 'g_id_number', 'g_address', 'g_city', 'g_country']);
    }

    #[Computed]
    public function availableRooms(): Collection
    {
        if (! $this->check_in || ! $this->check_out || ! $this->room_type_id) {
            return collect();
        }

        return app(RoomService::class)->availableRooms($this->check_in, $this->check_out, $this->room_type_id);
    }

    #[Computed]
    public function price(): array
    {
        if (! $this->room_id || ! $this->check_in || ! $this->check_out) {
            return ['subtotal' => 0, 'discount' => 0, 'tax' => 0, 'total' => 0, 'nights' => 0];
        }

        $room = \App\Models\Room::with('roomType')->find($this->room_id);

        if (! $room) {
            return ['subtotal' => 0, 'discount' => 0, 'tax' => 0, 'total' => 0, 'nights' => 0];
        }

        return app(BookingService::class)->calculatePrice($room, $this->check_in, $this->check_out, (float) $this->discount);
    }

    #[Computed]
    public function guestResults(): Collection
    {
        if (strlen(trim($this->guest_query)) < 2) {
            return collect();
        }

        return Guest::query()
            ->where(fn ($q) => $q->where('name', 'like', '%'.$this->guest_query.'%')
                ->orWhere('email', 'like', '%'.$this->guest_query.'%')
                ->orWhere('phone', 'like', '%'.$this->guest_query.'%'))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    #[Computed]
    public function roomTypes()
    {
        return RoomType::query()->where('status', 'active')->orderBy('base_price')->get();
    }

    public function submit(): void
    {
        $this->validate([
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'guest_id' => ['required', 'exists:guests,id'],
            'adults' => ['required', 'integer', 'min:1', 'max:10'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = app(BookingService::class)->createBooking([
            'room_id' => $this->room_id,
            'check_in_date' => $this->check_in,
            'check_out_date' => $this->check_out,
            'adults' => $this->adults,
            'children' => $this->children,
            'special_requests' => $this->special_requests ?: null,
            'discount' => (float) $this->discount,
            'source' => 'walk-in',
            'guest_id' => $this->guest_id,
        ], auth()->user());

        session()->flash('message', "Booking {$booking->booking_number} created.");

        $this->redirect(route('admin.bookings.show', $booking));
    }

    public function render()
    {
        return view('livewire.admin.create-booking');
    }
}
