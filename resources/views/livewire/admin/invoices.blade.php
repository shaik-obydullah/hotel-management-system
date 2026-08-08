<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Invoices &amp; Payments</h1>
            <p class="text-slate-500 text-sm mt-1">Billing overview</p>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 mt-6">
        <div class="card p-5">
            <div class="text-sm text-slate-500">Outstanding balance</div>
            <div class="text-3xl font-bold text-rose-600 mt-1">{{ money($this->totals['outstanding']) }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500">Total collected</div>
            <div class="text-3xl font-bold text-emerald-600 mt-1">{{ money($this->totals['collected']) }}</div>
        </div>
    </div>

    <div class="card mt-6 p-4">
        <div class="grid gap-3 md:grid-cols-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search invoice, booking #, guest…" class="input md:col-span-2">
            <select wire:model.live="statusFilter" class="input">
                <option value="">All statuses</option>
                @foreach (['unpaid' => 'Unpaid', 'partially-paid' => 'Partially Paid', 'paid' => 'Paid', 'cancelled' => 'Cancelled'] as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card mt-4 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Invoice #</th>
                    <th class="table-th">Booking</th>
                    <th class="table-th">Guest</th>
                    <th class="table-th">Date</th>
                    <th class="table-th">Total</th>
                    <th class="table-th">Paid</th>
                    <th class="table-th">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->invoices as $invoice)
                    <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('admin.invoices.show', $invoice) }}'">
                        <td class="table-td font-medium text-indigo-600">{{ $invoice->invoice_number }}</td>
                        <td class="table-td">{{ $invoice->booking?->booking_number }}</td>
                        <td class="table-td">{{ $invoice->booking?->guest?->name }}</td>
                        <td class="table-td">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                        <td class="table-td font-semibold">{{ money($invoice->total) }}</td>
                        <td class="table-td text-emerald-600">{{ money($invoice->paid) }}</td>
                        <td class="table-td">
                            <span class="badge {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($invoice->status === 'cancelled' ? 'bg-slate-200 text-slate-700' : ($invoice->status === 'partially-paid' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-700')) }}">
                                {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $invoice->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="table-td text-center text-slate-400 py-8">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $this->invoices->links() }}</div>
    </div>
</div>
