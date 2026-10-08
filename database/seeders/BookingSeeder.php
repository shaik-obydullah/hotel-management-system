<?php

namespace Database\Seeders;

use App\Enums\BookingSource;
use App\Enums\BookingStatus;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\BookingStatusHistory;
use App\Models\Guest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService as BookingServiceClass;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    protected array $usedBookingNumbers = [];

    protected array $ranges = [];

    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();
        $staff = User::query()->where('email', 'staff@example.com')->first();
        $guests = Guest::query()->get();
        $services = Service::query()->get();
        $rooms = Room::query()->with('roomType')->get();

        $today = CarbonImmutable::today();

        $historical = [];
        $start = CarbonImmutable::create(2026, 1, 5);
        $end = CarbonImmutable::create(2026, 7, 29);
        for ($i = 0; $i < 18; $i++) {
            $checkOut = $start->addDays(random_int(0, $start->diffInDays($end)));
            $nights = random_int(1, 7);
            $checkIn = $checkOut->subDays($nights);
            $historical[] = compact('checkIn', 'checkOut');
        }

        $currentStays = [];
        for ($i = 0; $i < 3; $i++) {
            $checkIn = $today->subDays(random_int(1, 4));
            $checkOut = $checkIn->addDays(random_int(4, 8));
            $currentStays[] = compact('checkIn', 'checkOut');
        }
        $currentStays[] = ['checkIn' => $today, 'checkOut' => $today->addDays(3)];
        $currentStays[] = ['checkIn' => $today, 'checkOut' => $today->addDays(5)];

        $futureConfirmed = [];
        for ($i = 0; $i < 13; $i++) {
            $checkIn = $today->addDays(random_int(1, 70));
            $checkOut = $checkIn->addDays(random_int(2, 6));
            $futureConfirmed[] = compact('checkIn', 'checkOut');
        }

        $pending = [];
        for ($i = 0; $i < 3; $i++) {
            $checkIn = $today->addDays(random_int(1, 5));
            $checkOut = $checkIn->addDays(random_int(1, 3));
            $pending[] = compact('checkIn', 'checkOut');
        }

        $cancelled = [
            ['checkIn' => $today->subDays(10), 'checkOut' => $today->subDays(6), 'reason' => 'Guest cancelled due to illness.'],
            ['checkIn' => $today->addDays(8), 'checkOut' => $today->addDays(12), 'reason' => 'Double booking, guest chose another property.'],
            ['checkIn' => $today->addDays(20), 'checkOut' => $today->addDays(23), 'reason' => 'Flight itinerary changed.'],
        ];

        foreach ($historical as $i => $dates) {
            $this->createBooking($dates['checkIn'], $dates['checkOut'], $guests, $rooms, BookingStatus::CheckedOut, BookingSource::Online, $admin, $services, $staff);
        }

        foreach ($currentStays as $i => $dates) {
            $this->createBooking($dates['checkIn'], $dates['checkOut'], $guests, $rooms, BookingStatus::CheckedIn, BookingSource::WalkIn, $staff, $services, $staff);
        }

        foreach ($futureConfirmed as $i => $dates) {
            $source = [$bookingSource = BookingSource::Online, BookingSource::Online, BookingSource::Phone, BookingSource::WalkIn][$i % 4];
            $this->createBooking($dates['checkIn'], $dates['checkOut'], $guests, $rooms, BookingStatus::Confirmed, $source, $i % 2 ? $staff : $admin, $services, $staff, true);
        }

        foreach ($pending as $i => $dates) {
            $this->createBooking($dates['checkIn'], $dates['checkOut'], $guests, $rooms, BookingStatus::Pending, BookingSource::Phone, null, $services, $staff);
        }

        foreach ($cancelled as $dates) {
            $this->createBooking($dates['checkIn'], $dates['checkOut'], $guests, $rooms, BookingStatus::Cancelled, BookingSource::Online, $admin, $services, $staff, true, $dates['reason']);
        }

        $this->setRoomStatuses();
    }

    protected function createBooking(
        CarbonImmutable $checkIn,
        CarbonImmutable $checkOut,
        $guests,
        $rooms,
        BookingStatus $status,
        BookingSource $source,
        ?User $actor,
        $services,
        ?User $staffActor,
        bool $skipServices = false,
        ?string $cancelReason = null,
    ): Booking {
        $room = $this->pickRoom($rooms, $checkIn, $checkOut);

        $price = app(BookingServiceClass::class)->calculatePrice($room, $checkIn, $checkOut);

        $createdAt = $checkIn->subDays(random_int(1, 14))->lt(CarbonImmutable::now())
            ? $checkIn->subDays(random_int(1, 14))
            : CarbonImmutable::now()->subDay();

        $booking = Booking::create([
            'booking_number' => $this->uniqueBookingNumber($checkIn),
            'guest_id' => $guests->random()->id,
            'room_id' => $room->id,
            'check_in_date' => $checkIn->toDateString(),
            'check_out_date' => $checkOut->toDateString(),
            'adults' => random_int(1, max(1, $room->roomType->max_guests)),
            'children' => random_int(0, 1),
            'status' => $status,
            'source' => $source,
            'special_requests' => rand(0, 2) === 0 ? 'Extra towels, please.' : null,
            'room_rate' => $price['rates'][$checkIn->toDateString()] ?? $price['subtotal'] / max(1, $price['nights']),
            'nights' => $price['nights'],
            'subtotal' => $price['subtotal'],
            'discount' => $price['discount'],
            'tax' => $price['tax'],
            'total_amount' => $price['total'],
            'paid_amount' => 0,
            'created_by' => $actor?->id,
            'created_at' => $createdAt,
        ]);

        BookingStatusHistory::create([
            'booking_id' => $booking->id,
            'status' => $status->value,
            'changed_by' => $actor?->id,
            'notes' => match ($status) {
                BookingStatus::CheckedOut => 'Guest checked out',
                BookingStatus::CheckedIn => 'Guest checked in',
                BookingStatus::Cancelled => $cancelReason,
                default => 'Booking created',
            },
            'created_at' => $createdAt,
        ]);

        if (! $skipServices && in_array($status, [BookingStatus::CheckedIn, BookingStatus::CheckedOut], true)) {
            $this->addServices($booking, $services, $staffActor);
        }

        if ($status === BookingStatus::CheckedOut) {
            $this->createInvoice($booking, $staffActor);
        }

        return $booking;
    }

    protected function pickRoom($rooms, CarbonImmutable $checkIn, CarbonImmutable $checkOut): Room
    {
        $candidates = $rooms->filter(function (Room $room) use ($checkIn, $checkOut) {
            foreach ($this->ranges[$room->id] ?? [] as [$in, $out]) {
                if ($in->lt($checkOut) && $out->gt($checkIn)) {
                    return false;
                }
            }

            return true;
        });

        if ($candidates->isEmpty()) {
            $room = $rooms->random();
        } else {
            $room = $candidates->random();
        }

        $this->ranges[$room->id][] = [$checkIn, $checkOut];

        return $room;
    }

    protected function uniqueBookingNumber(CarbonImmutable $date): string
    {
        do {
            $number = 'GAZ-'.$date->format('Ymd').'-'.random_int(1000, 9999);
        } while (in_array($number, $this->usedBookingNumbers, true));

        $this->usedBookingNumbers[] = $number;

        return $number;
    }

    protected function addServices(Booking $booking, $services, ?User $staffActor): void
    {
        $count = random_int(0, 3);
        foreach ($services->random($count) as $service) {
            $quantity = random_int(1, 2);
            BookingService::create([
                'booking_id' => $booking->id,
                'service_id' => $service->id,
                'quantity' => $quantity,
                'amount' => (float) $service->price * $quantity,
                'notes' => null,
            ]);
        }
    }

    protected function createInvoice(Booking $booking, ?User $staffActor): void
    {
        $servicesTotal = (float) $booking->bookingServices()->sum('amount');
        $subtotal = (float) $booking->subtotal + $servicesTotal;
        $tax = round($subtotal * 0.10, 2);
        $total = round($subtotal + $tax, 2);

        $invoiceNumber = 'INV-'.$booking->check_out_date->format('Ymd').'-'.random_int(1000, 9999);
        while (Invoice::query()->where('invoice_number', $invoiceNumber)->exists()) {
            $invoiceNumber = 'INV-'.$booking->check_out_date->format('Ymd').'-'.random_int(1000, 9999);
        }

        $roll = random_int(1, 100);
        $paidFraction = $roll <= 60 ? 1.0 : ($roll <= 85 ? 0.5 : 0.0);

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'booking_id' => $booking->id,
            'invoice_date' => $booking->check_out_date->toDateString(),
            'subtotal' => $subtotal,
            'discount' => $booking->discount,
            'tax' => $tax,
            'total' => $total,
            'paid' => round($total * $paidFraction, 2),
            'status' => $paidFraction >= 1.0 ? InvoiceStatus::Paid : ($paidFraction > 0 ? InvoiceStatus::Partial : InvoiceStatus::Unpaid),
        ]);

        if ($paidFraction > 0) {
            $paidAt = $booking->check_out_date->addMinutes(random_int(180, 1500));

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $invoice->paid,
                'method' => $this->randomMethod()->value,
                'reference' => 'TXN-'.strtoupper(bin2hex(random_bytes(4))),
                'status' => 'completed',
                'received_by' => $staffActor?->id,
                'paid_at' => $paidAt->lt(CarbonImmutable::now()) ? $paidAt : CarbonImmutable::now()->subHours(random_int(1, 6)),
                'notes' => null,
            ]);

            $booking->update(['paid_amount' => $invoice->paid]);
        }
    }

    protected function randomMethod(): PaymentMethod
    {
        return [PaymentMethod::Cash, PaymentMethod::Card, PaymentMethod::Card, PaymentMethod::BankTransfer, PaymentMethod::Online][random_int(0, 4)];
    }

    protected function setRoomStatuses(): void
    {
        $occupiedRoomIds = Booking::query()
            ->where('status', BookingStatus::CheckedIn->value)
            ->pluck('room_id');

        Room::query()->whereIn('id', $occupiedRoomIds)->update(['status' => 'occupied']);

        $maintenance = Room::query()->where('status', '!=', 'occupied')->orderBy('id')->take(2)->pluck('id');
        Room::query()->whereIn('id', $maintenance)->update(['status' => 'maintenance']);
    }
}
