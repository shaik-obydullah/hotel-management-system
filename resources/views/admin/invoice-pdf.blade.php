<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #4f46e5; padding-bottom: 16px; margin-bottom: 24px; }
        .hotel-name { font-size: 22px; font-weight: bold; color: #4f46e5; }
        .muted { color: #64748b; font-size: 11px; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; background: #f1f5f9; padding: 8px; font-size: 10px; text-transform: uppercase; letter-spacing: .5px; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; }
        .right { text-align: right; }
        .totals td { border-bottom: none; padding: 4px 8px; }
        .grand { font-size: 15px; font-weight: bold; color: #4f46e5; }
        .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="hotel-name">{{ $hotel->name }}</div>
            <div class="muted">{{ $hotel->tagline }}</div>
            <div class="muted">{{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}</div>
        </div>
        <div class="right">
            <div style="font-size:16px; font-weight:bold;">INVOICE</div>
            <div class="muted">{{ $invoice->invoice_number }}</div>
            <div class="muted">Date: {{ $invoice->invoice_date->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="meta">
        <div>
            <div class="muted">BILL TO</div>
            <div style="font-weight:bold;">{{ $invoice->booking->guest->name }}</div>
            <div>{{ $invoice->booking->guest->email }}</div>
            <div>{{ $invoice->booking->guest->phone }}</div>
            <div>{{ $invoice->booking->guest->address }}</div>
        </div>
        <div class="right">
            <div class="muted">BOOKING</div>
            <div style="font-weight:bold;">{{ $invoice->booking->booking_number }}</div>
            <div>Room {{ $invoice->booking->room->room_number }} — {{ $invoice->booking->room->roomType->name }}</div>
            <div>{{ $invoice->booking->check_in_date->format('M d, Y') }} → {{ $invoice->booking->check_out_date->format('M d, Y') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="right">Qty</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $invoice->booking->room->roomType->name }} (Room {{ $invoice->booking->room->room_number }})
                    <br><span class="muted">{{ $invoice->booking->check_in_date->format('M d, Y') }} → {{ $invoice->booking->check_out_date->format('M d, Y') }}</span>
                </td>
                <td class="right">{{ $invoice->booking->nights }}</td>
                <td class="right">{{ money($invoice->booking->subtotal) }}</td>
            </tr>
            @foreach ($invoice->booking->bookingServices as $item)
                <tr>
                    <td>{{ $item->service->name }} <span class="muted">({{ $item->service->category }})</span></td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">{{ money($item->amount) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 320px; margin-left: auto; margin-top: 8px;">
        <tr class="totals"><td>Subtotal</td><td class="right">{{ money($invoice->subtotal) }}</td></tr>
        @if ((float) $invoice->discount > 0)
            <tr class="totals"><td>Discount</td><td class="right">-{{ money($invoice->discount) }}</td></tr>
        @endif
        <tr class="totals"><td>Tax</td><td class="right">{{ money($invoice->tax) }}</td></tr>
        <tr class="totals"><td class="grand">TOTAL</td><td class="right grand">{{ money($invoice->total) }}</td></tr>
        <tr class="totals"><td>Paid</td><td class="right">{{ money($invoice->paid) }}</td></tr>
        <tr class="totals"><td>Balance due</td><td class="right">{{ money($invoice->balance()) }}</td></tr>
    </table>

    <div class="footer">
        Check-in {{ \Carbon\Carbon::parse($hotel->check_in_time)->format('g:i A') }} · Check-out {{ \Carbon\Carbon::parse($hotel->check_out_time)->format('g:i A') }} ·
        {{ $hotel->phone }} · {{ $hotel->email }}
        <br>Thank you for staying with {{ $hotel->name }}!
    </div>
</body>
</html>
