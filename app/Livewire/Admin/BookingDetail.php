<?php

namespace App\Livewire\Admin;

use App\Enums\PaymentMethod;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Invoice;
use App\Models\Service;
use App\Services\BillingService;
use App\Services\BookingService as BookingServiceApp;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Booking Detail')]
class BookingDetail extends Component
{
    public Booking $booking;

    public string $service_id = '';
    public int $quantity = 1;
    public string $service_notes = '';

    public string $pay_amount = '';
    public string $pay_method = 'cash';
    public string $pay_reference = '';

    public string $cancel_reason = '';
    public string $action_notes = '';
    public bool $showCancelConfirm = false;

    public function mount(Booking $booking): void
    {
        $this->booking = $booking->load(['guest', 'room.roomType', 'creator', 'bookingServices.service', 'statusHistory.changedBy']);
    }

    #[Computed]
    public function services()
    {
        return Service::query()->where('status', 'active')->orderBy('category')->orderBy('name')->get();
    }

    #[Computed]
    public function activeInvoice(): ?Invoice
    {
        return $this->booking->invoice;
    }

    public function confirmBooking(): void
    {
        app(BookingServiceApp::class)->confirm($this->booking, auth()->user());
        $this->booking->refresh();
        session()->flash('message', 'Booking confirmed.');
    }

    public function checkIn(): void
    {
        app(BookingServiceApp::class)->checkIn($this->booking, auth()->user(), $this->action_notes ?: null);
        $this->booking->refresh();
        $this->action_notes = '';
        session()->flash('message', 'Guest checked in. Room marked as occupied.');
    }

    public function checkOut(): void
    {
        app(BookingServiceApp::class)->checkOut($this->booking, auth()->user(), $this->action_notes ?: null);
        $this->booking->refresh();
        $this->action_notes = '';
        session()->flash('message', 'Guest checked out. Invoice generated and room sent to cleaning.');
    }

    public function cancelBooking(): void
    {
        $this->validate(['cancel_reason' => ['required', 'string', 'min:3']]);

        app(BookingServiceApp::class)->cancel($this->booking, auth()->user(), $this->cancel_reason);
        $this->booking->refresh();
        $this->cancel_reason = '';
        $this->showCancelConfirm = false;
        session()->flash('message', 'Booking cancelled.');
    }

    public function addService(): void
    {
        $this->validate([
            'service_id' => ['required', 'exists:services,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'service_notes' => ['nullable', 'string', 'max:300'],
        ]);

        $service = Service::findOrFail($this->service_id);

        BookingService::create([
            'booking_id' => $this->booking->id,
            'service_id' => $service->id,
            'quantity' => $this->quantity,
            'amount' => (float) $service->price * $this->quantity,
            'notes' => $this->service_notes ?: null,
        ]);

        $this->refreshInvoice();

        $this->reset(['service_id', 'quantity', 'service_notes']);
        $this->booking->refresh();
        session()->flash('message', 'Service charge added.');
    }

    public function removeService(int $id): void
    {
        BookingService::where('id', $id)->where('booking_id', $this->booking->id)->delete();
        $this->refreshInvoice();
        $this->booking->refresh();
        session()->flash('message', 'Service charge removed.');
    }

    public function recordPayment(): void
    {
        $this->validate([
            'pay_amount' => ['required', 'numeric', 'gt:0'],
            'pay_method' => ['required', 'in:'.implode(',', array_column(PaymentMethod::cases(), 'value'))],
            'pay_reference' => ['nullable', 'string', 'max:100'],
        ]);

        $invoice = app(BillingService::class)->getOrCreateInvoice($this->booking);
        $amount = min((float) $this->pay_amount, (float) $invoice->balance());

        if ($amount <= 0) {
            $this->addError('pay_amount', 'This invoice has no outstanding balance.');

            return;
        }

        app(BillingService::class)->recordPayment(
            $invoice,
            $amount,
            $this->pay_method,
            $this->pay_reference ?: null,
            auth()->user(),
        );

        $this->reset(['pay_amount', 'pay_reference']);
        $this->booking->refresh();
        session()->flash('message', 'Payment recorded.');
    }

    protected function refreshInvoice(): void
    {
        $invoice = $this->booking->invoice;

        if (! $invoice) {
            return;
        }

        $taxRate = (float) \App\Models\HotelInfo::current()->tax_rate;
        $subtotal = (float) $this->booking->subtotal + (float) $this->booking->bookingServices()->sum('amount');
        $tax = round($subtotal * ($taxRate / 100), 2);
        $total = round($subtotal + $tax, 2);

        $invoice->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.booking-detail');
    }
}
