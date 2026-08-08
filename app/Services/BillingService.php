<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class BillingService
{
    public function generateInvoiceNumber(): string
    {
        return 'INV-'.now()->format('Ymd').'-'.strtoupper(random_int(1000, 9999));
    }

    public function generateInvoiceForBooking(Booking $booking): Invoice
    {
        $hotelTaxRate = (float) \App\Models\HotelInfo::current()->tax_rate;
        $subtotal = (float) $booking->subtotal + (float) $booking->bookingServices()->sum('amount');
        $tax = round($subtotal * ($hotelTaxRate / 100), 2);
        $total = round($subtotal + $tax, 2);

        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'booking_id' => $booking->id,
            'invoice_date' => now()->toDateString(),
            'subtotal' => $subtotal,
            'discount' => $booking->discount,
            'tax' => $tax,
            'total' => $total,
            'paid' => 0,
            'status' => InvoiceStatus::Unpaid->value,
        ]);

        return $invoice->load('booking.guest');
    }

    public function recordPayment(Invoice $invoice, float $amount, string $method, ?string $reference = null, ?User $receivedBy = null, ?string $notes = null): Payment
    {
        return DB::transaction(function () use ($invoice, $amount, $method, $reference, $receivedBy, $notes) {
            $invoice->refresh();
            $remaining = round((float) $invoice->total - (float) $invoice->paid, 2);
            $amount = min($amount, max(0, $remaining));

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amount,
                'method' => $method,
                'reference' => $reference,
                'status' => PaymentStatus::Completed->value,
                'received_by' => $receivedBy?->id,
                'paid_at' => now(),
                'notes' => $notes,
            ]);

            $newPaid = round((float) $invoice->paid + $amount, 2);
            $status = abs($newPaid - (float) $invoice->total) < 0.009
                ? InvoiceStatus::Paid
                : InvoiceStatus::Partial;

            $invoice->update([
                'paid' => $newPaid,
                'status' => $status->value,
            ]);

            $booking = $invoice->booking;
            if ($booking) {
                $booking->update(['paid_amount' => $newPaid]);
            }

            return $payment->load('invoice.booking');
        });
    }

    public function refund(Payment $payment, ?string $reason = null): Payment
    {
        return DB::transaction(function () use ($payment, $reason) {
            $payment->update([
                'status' => PaymentStatus::Refunded->value,
                'notes' => ($payment->notes ? $payment->notes."\n" : '')."Refunded: {$reason}",
            ]);

            $invoice = $payment->invoice;
            $newPaid = round((float) $invoice->paid - (float) $payment->amount, 2);
            $status = $newPaid <= 0
                ? InvoiceStatus::Unpaid
                : InvoiceStatus::Partial;

            $invoice->update(['paid' => $newPaid, 'status' => $status->value]);

            return $payment->fresh();
        });
    }

    /**
     * @throws Throwable
     */
    public function getOrCreateInvoice(Booking $booking): Invoice
    {
        if ($booking->invoice) {
            return $booking->invoice;
        }

        return $this->generateInvoiceForBooking($booking);
    }
}
