<?php

namespace App\Livewire\Admin;

use App\Enums\PaymentMethod;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\BillingService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Invoice')]
class InvoiceDetail extends Component
{
    public Invoice $invoice;

    public string $pay_amount = '';
    public string $pay_method = 'cash';
    public string $pay_reference = '';
    public string $refund_reason = '';

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice->load(['booking.guest', 'booking.room.roomType', 'booking.bookingServices.service', 'payments']);
    }

    #[Computed]
    public function balance(): float
    {
        return $this->invoice->balance();
    }

    public function recordPayment(): void
    {
        $this->validate([
            'pay_amount' => ['required', 'numeric', 'gt:0'],
            'pay_method' => ['required', 'in:'.implode(',', array_column(PaymentMethod::cases(), 'value'))],
            'pay_reference' => ['nullable', 'string', 'max:100'],
        ]);

        $amount = min((float) $this->pay_amount, $this->balance);

        if ($amount <= 0) {
            $this->addError('pay_amount', 'No outstanding balance.');

            return;
        }

        app(BillingService::class)->recordPayment(
            $this->invoice,
            $amount,
            $this->pay_method,
            $this->pay_reference ?: null,
            auth()->user(),
        );

        $this->reset(['pay_amount', 'pay_reference']);
        $this->invoice->refresh();
        $this->dispatch('invoice-updated');
        session()->flash('message', 'Payment recorded.');
    }

    public function refund(int $paymentId): void
    {
        $this->validate(['refund_reason' => ['nullable', 'string', 'max:300']]);

        $payment = Payment::where('id', $paymentId)->where('invoice_id', $this->invoice->id)->firstOrFail();

        app(BillingService::class)->refund($payment, $this->refund_reason ?: 'Refunded by staff');
        $this->refund_reason = '';
        $this->invoice->refresh();
        session()->flash('message', 'Payment refunded.');
    }

    public function render()
    {
        return view('livewire.admin.invoice-detail');
    }
}
