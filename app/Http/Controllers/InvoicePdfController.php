<?php

namespace App\Http\Controllers;

use App\Models\HotelInfo;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfController extends Controller
{
    public function show(Invoice $invoice)
    {
        $invoice->load(['booking.guest', 'booking.room.roomType', 'booking.bookingServices.service']);

        $pdf = Pdf::loadView('admin.invoice-pdf', [
            'invoice' => $invoice,
            'hotel' => HotelInfo::current(),
        ]);

        return $pdf->download($invoice->invoice_number.'.pdf');
    }
}
