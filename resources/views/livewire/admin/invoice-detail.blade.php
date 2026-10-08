<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-indigo-600">{{ $invoice->invoice_number }}</h1>
                <span class="badge {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($invoice->status === 'cancelled' ? 'bg-slate-200 text-slate-700' : ($invoice->status === 'partially-paid' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-700')) }}">
                    {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $invoice->status)) }}
                </span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Issued {{ $invoice->invoice_date->format('M d, Y') }} · Booking {{ $invoice->booking?->booking_number }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.invoices') }}" class="btn-ghost">← Back</a>
            <a href="{{ route('admin.bookings.show', $invoice->booking) }}" class="btn-secondary">View booking</a>
            <a href="{{ route('admin.invoices.pdf', $invoice) }}" target="_blank" class="btn-primary">PDF</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mt-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 bg-slate-50"><h2 class="font-bold">Line items</h2></div>
                <table class="table-wrap">
                    <thead>
                        <tr>
                            <th class="table-th">Description</th>
                            <th class="table-th">Qty</th>
                            <th class="table-th text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table-td">
                                <div class="font-medium">{{ $invoice->booking?->room?->roomType?->name }} — Room {{ $invoice->booking?->room?->room_number }}</div>
                                <div class="text-xs text-slate-500">{{ $invoice->booking?->check_in_date->format('M d, Y') }} → {{ $invoice->booking?->check_out_date->format('M d, Y') }} · {{ $invoice->booking?->nights }} night(s)</div>
                            </td>
                            <td class="table-td">{{ $invoice->booking?->nights }}</td>
                            <td class="table-td text-right font-medium">{{ money($invoice->booking?->subtotal) }}</td>
                        </tr>
                        @foreach ($invoice->booking?->bookingServices ?? [] as $item)
                            <tr>
                                <td class="table-td">
                                    <div class="font-medium">{{ $item->service->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->service->category }}</div>
                                </td>
                                <td class="table-td">× {{ $item->quantity }}</td>
                                <td class="table-td text-right font-medium">{{ money($item->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-50">
                            <td class="table-td text-right" colspan="2"><span class="font-semibold">Subtotal</span></td>
                            <td class="table-td text-right font-semibold">{{ money($invoice->subtotal) }}</td>
                        </tr>
                        @if ((float) $invoice->discount > 0)
                            <tr class="bg-slate-50">
                                <td class="table-td text-right" colspan="2"><span class="font-semibold">Discount</span></td>
                                <td class="table-td text-right font-semibold text-emerald-600">-{{ money($invoice->discount) }}</td>
                            </tr>
                        @endif
                        <tr class="bg-slate-50">
                            <td class="table-td text-right" colspan="2"><span class="font-semibold">Tax</span></td>
                            <td class="table-td text-right font-semibold">{{ money($invoice->tax) }}</td>
                        </tr>
                        <tr class="bg-indigo-50">
                            <td class="table-td text-right" colspan="2"><span class="font-bold text-base">Total</span></td>
                            <td class="table-td text-right font-bold text-base text-indigo-600">{{ money($invoice->total) }}</td>
                        </tr>
                        <tr>
                            <td class="table-td text-right" colspan="2"><span class="font-medium">Paid</span></td>
                            <td class="table-td text-right font-medium text-emerald-600">{{ money($invoice->paid) }}</td>
                        </tr>
                        <tr>
                            <td class="table-td text-right" colspan="2"><span class="font-medium">Balance</span></td>
                            <td class="table-td text-right font-bold {{ $this->balance > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ money($this->balance) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 bg-slate-50"><h2 class="font-bold">Payments</h2></div>
                @if ($invoice->payments->isNotEmpty())
                    <table class="table-wrap">
                        <thead>
                            <tr>
                                <th class="table-th">Date</th>
                                <th class="table-th">Method</th>
                                <th class="table-th">Reference</th>
                                <th class="table-th">Amount</th>
                                <th class="table-th">Status</th>
                                <th class="table-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->payments as $payment)
                                <tr>
                                    <td class="table-td">{{ $payment->paid_at?->format('M d, Y g:i A') }}</td>
                                    <td class="table-td">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $payment->method)) }}</td>
                                    <td class="table-td">{{ $payment->reference ?? '—' }}</td>
                                    <td class="table-td font-medium">{{ money($payment->amount) }}</td>
                                    <td class="table-td">
                                        <span class="badge {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'refunded' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-500') }}">{{ $payment->status }}</span>
                                    </td>
                                    <td class="table-td">
                                        @if ($payment->status === 'completed')
                                            <button wire:click="refund({{ $payment->id }})" wire:confirm="Refund this payment?" class="text-xs text-rose-600 hover:underline">Refund</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-sm text-slate-400 p-5">No payments recorded yet.</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="card p-6">
                <h2 class="font-bold mb-4">Record payment</h2>
                <form wire:submit="recordPayment" class="space-y-4">
                    <div>
                        <label class="label">Amount *</label>
                        <input type="number" step="0.01" wire:model="pay_amount" class="input" placeholder="{{ $this->balance }}">
                        @error('pay_amount') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Method *</label>
                        <select wire:model="pay_method" class="input">
                            @foreach (\App\Enums\PaymentMethod::cases() as $m)
                                <option value="{{ $m->value }}">{{ $m->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Reference</label>
                        <input type="text" wire:model="pay_reference" class="input" placeholder="Card / transaction ref">
                    </div>
                    <button type="submit" class="btn-emerald w-full" {{ $this->balance <= 0 ? 'disabled' : '' }}>Record payment</button>
                </form>
            </div>

            <div class="card p-6">
                <h2 class="font-bold mb-3">Guest</h2>
                <div class="font-semibold">{{ $invoice->booking?->guest?->name }}</div>
                <div class="text-sm text-slate-500">{{ $invoice->booking?->guest?->email }}</div>
                <div class="text-sm text-slate-500">{{ $invoice->booking?->guest?->phone }}</div>
            </div>
        </div>
    </div>
</div>
