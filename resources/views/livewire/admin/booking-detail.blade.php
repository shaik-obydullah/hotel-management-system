<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-indigo-600">{{ $booking->booking_number }}</h1>
                <span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span>
            </div>
            <p class="text-slate-500 text-sm mt-1">Created {{ $booking->created_at->format('M d, Y g:i A') }} · {{ $booking->source->label() }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bookings') }}" class="btn-ghost">← Back</a>
            @if ($booking->status === \App\Enums\BookingStatus::Pending)
                <button wire:click="confirmBooking" class="btn-primary">Confirm</button>
            @endif
            @if ($booking->status === \App\Enums\BookingStatus::Confirmed)
                <button wire:click="checkIn" class="btn-emerald">Check in</button>
                <button wire:click="$set('showCancelConfirm', true)" class="btn-danger">Cancel</button>
            @endif
            @if ($booking->status === \App\Enums\BookingStatus::CheckedIn)
                <button wire:click="checkOut" class="btn-emerald">Check out</button>
            @endif
        </div>
    </div>

    @if ($showCancelConfirm)
        <div class="modal-backdrop" wire:click.self="$set('showCancelConfirm', false)">
            <div class="modal-panel p-6">
                <h2 class="text-lg font-bold mb-1">Cancel booking {{ $booking->booking_number }}?</h2>
                <p class="text-sm text-slate-500">This will release the room for the booked dates.</p>
                <form wire:submit="cancelBooking" class="mt-4 space-y-4">
                    <div>
                        <label class="label">Reason *</label>
                        <textarea wire:model="cancel_reason" rows="3" class="input" placeholder="Why is this booking being cancelled?"></textarea>
                        @error('cancel_reason') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showCancelConfirm', false)" class="btn-secondary">Keep booking</button>
                        <button type="submit" class="btn-danger">Cancel booking</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3 mt-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Guest & room --}}
            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 bg-slate-50"><h2 class="font-bold">Guest &amp; room</h2></div>
                <div class="p-5 grid sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <div class="text-xs text-slate-500 uppercase mb-2">Guest</div>
                        <div class="font-semibold text-base">{{ $booking->guest->name }}</div>
                        <div class="text-slate-600">{{ $booking->guest->email }}</div>
                        <div class="text-slate-600">{{ $booking->guest->phone }}</div>
                        <div class="text-slate-600">{{ $booking->guest->nationality }}</div>
                        <a href="{{ route('admin.guests.show', $booking->guest) }}" class="text-indigo-600 text-xs hover:underline mt-2 inline-block">View guest profile →</a>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase mb-2">Room</div>
                        <div class="font-semibold text-base">Room {{ $booking->room->room_number }}</div>
                        <div class="text-slate-600">{{ $booking->room->roomType->name }}</div>
                        <div class="text-slate-600">{{ $booking->room->floor->name }}</div>
                        <span class="badge {{ $booking->room->status->color() }} mt-2">{{ $booking->room->status->label() }}</span>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase mb-2">Check-in</div>
                        <div class="font-semibold">{{ $booking->check_in_date->format('D, M d, Y') }}</div>
                        <div class="text-slate-500 text-xs">from {{ \Carbon\Carbon::parse(\App\Models\HotelInfo::current()->check_in_time)->format('g:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase mb-2">Check-out</div>
                        <div class="font-semibold">{{ $booking->check_out_date->format('D, M d, Y') }}</div>
                        <div class="text-slate-500 text-xs">by {{ \Carbon\Carbon::parse(\App\Models\HotelInfo::current()->check_out_time)->format('g:i A') }}</div>
                    </div>
                </div>
                @if ($booking->special_requests)
                    <div class="mx-5 mb-5 rounded-lg bg-amber-50 border border-amber-200 p-3 text-sm text-amber-800">
                        <strong>Special requests:</strong> {{ $booking->special_requests }}
                    </div>
                @endif
            </div>

            {{-- Services --}}
            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h2 class="font-bold">Services &amp; charges</h2>
                    <span class="badge bg-slate-100 text-slate-700">{{ money($booking->servicesTotal()) }}</span>
                </div>
                <div class="p-5">
                    @if ($booking->bookingServices->isNotEmpty())
                        <table class="table-wrap mb-4">
                            <thead>
                                <tr>
                                    <th class="table-th">Service</th>
                                    <th class="table-th">Qty</th>
                                    <th class="table-th">Amount</th>
                                    <th class="table-th"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking->bookingServices as $item)
                                    <tr>
                                        <td class="table-td">
                                            <div class="font-medium">{{ $item->service->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $item->service->category }}{{ $item->notes ? ' · '.$item->notes : '' }}</div>
                                        </td>
                                        <td class="table-td">× {{ $item->quantity }}</td>
                                        <td class="table-td font-medium">{{ money($item->amount) }}</td>
                                        <td class="table-td text-right">
                                            <button wire:click="removeService({{ $item->id }})" class="text-xs text-rose-600 hover:underline">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-sm text-slate-400 mb-4">No services charged yet.</p>
                    @endif

                    @if (in_array($booking->status->value, ['confirmed', 'checked-in']))
                        <form wire:submit="addService" class="grid sm:grid-cols-4 gap-3 items-end">
                            <div>
                                <label class="label">Service</label>
                                <select wire:model="service_id" class="input">
                                    <option value="">Select…</option>
                                    @foreach ($this->services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }} ({{ money($service->price) }})</option>
                                    @endforeach
                                </select>
                                @error('service_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="label">Qty</label>
                                <input type="number" wire:model="quantity" min="1" class="input">
                            </div>
                            <div>
                                <label class="label">Notes</label>
                                <input type="text" wire:model="service_notes" class="input" placeholder="Optional">
                            </div>
                            <button type="submit" class="btn-secondary">+ Add charge</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Invoice --}}
            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <h2 class="font-bold">Invoice</h2>
                    @if ($this->activeInvoice)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.invoices.show', $this->activeInvoice) }}" class="text-indigo-600 text-sm hover:underline">View invoice</a>
                            <a href="{{ route('admin.invoices.pdf', $this->activeInvoice) }}" class="btn-ghost text-xs px-2 py-1" target="_blank">PDF</a>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    @if ($this->activeInvoice)
                        <div class="flex flex-wrap gap-6">
                            <div>
                                <div class="text-xs text-slate-500 uppercase">Invoice number</div>
                                <div class="font-semibold">{{ $this->activeInvoice->invoice_number }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 uppercase">Total</div>
                                <div class="font-semibold">{{ money($this->activeInvoice->total) }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 uppercase">Paid</div>
                                <div class="font-semibold text-emerald-600">{{ money($this->activeInvoice->paid) }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 uppercase">Balance</div>
                                <div class="font-semibold {{ $this->activeInvoice->balance() > 0 ? 'text-rose-600' : '' }}">{{ money($this->activeInvoice->balance()) }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 uppercase">Status</div>
                                <span class="badge {{ $this->activeInvoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($this->activeInvoice->status === 'cancelled' ? 'bg-slate-200 text-slate-700' : 'bg-amber-100 text-amber-800') }} mt-1">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $this->activeInvoice->status)) }}</span>
                            </div>
                        </div>

                        @if ($this->activeInvoice->payments->isNotEmpty())
                            <table class="table-wrap mt-4">
                                <thead>
                                    <tr>
                                        <th class="table-th">Date</th>
                                        <th class="table-th">Method</th>
                                        <th class="table-th">Reference</th>
                                        <th class="table-th">Amount</th>
                                        <th class="table-th">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->activeInvoice->payments as $payment)
                                        <tr>
                                            <td class="table-td">{{ $payment->paid_at?->format('M d, Y g:i A') }}</td>
                                            <td class="table-td">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $payment->method)) }}</td>
                                            <td class="table-td">{{ $payment->reference }}</td>
                                            <td class="table-td font-medium">{{ money($payment->amount) }}</td>
                                            <td class="table-td">
                                                <span class="badge {{ $payment->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($payment->status === 'refunded' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-500') }}">{{ $payment->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        @if ($this->activeInvoice->balance() > 0 && ! in_array($booking->status->value, ['cancelled', 'checked-out']))
                            <form wire:submit="recordPayment" class="grid sm:grid-cols-4 gap-3 items-end mt-5 border-t border-slate-100 pt-4">
                                <div>
                                    <label class="label">Amount</label>
                                    <input type="number" step="0.01" wire:model="pay_amount" class="input" placeholder="{{ $this->activeInvoice->balance() }}">
                                    @error('pay_amount') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="label">Method</label>
                                    <select wire:model="pay_method" class="input">
                                        @foreach (\App\Enums\PaymentMethod::cases() as $m)
                                            <option value="{{ $m->value }}">{{ $m->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="label">Reference</label>
                                    <input type="text" wire:model="pay_reference" class="input" placeholder="Optional">
                                </div>
                                <button type="submit" class="btn-emerald">Record payment</button>
                            </form>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <p class="text-sm text-slate-400">No invoice yet — generated automatically at check-out.</p>
                            @if ($booking->status === \App\Enums\BookingStatus::CheckedIn)
                                <button wire:click="$set('pay_amount', '{{ $booking->total_amount }}')" class="btn-secondary mt-3">Collect advance payment ({{ money($booking->total_amount) }})</button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="card p-5">
                <h2 class="font-bold mb-3">Totals</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-600">{{ $booking->nights }} night(s) × {{ money($booking->room_rate) }}</span><span>{{ money($booking->subtotal) }}</span></div>
                    @if ((float) $booking->discount > 0)
                        <div class="flex justify-between text-emerald-600"><span>Discount</span><span>-{{ money($booking->discount) }}</span></div>
                    @endif
                    <div class="flex justify-between"><span class="text-slate-600">Tax</span><span>{{ money($booking->tax) }}</span></div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-bold"><span>Total</span><span class="text-indigo-600">{{ money($booking->total_amount) }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Paid</span><span class="text-emerald-600">{{ money($booking->paid_amount) }}</span></div>
                </div>
            </div>

            <div class="card p-5">
                <h2 class="font-bold mb-3">Status history</h2>
                <ol class="relative space-y-3 border-l border-slate-200 ml-2">
                    @foreach ($booking->statusHistory as $history)
                        <li class="ml-4">
                            <span class="absolute -left-1.5 mt-1.5 w-3 h-3 rounded-full bg-indigo-500 border-2 border-white"></span>
                            <div class="font-medium text-sm">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $history->status)) }}</div>
                            <div class="text-xs text-slate-500">{{ $history->created_at->format('M d, Y g:i A') }}</div>
                            @if ($history->notes) <div class="text-xs text-slate-500 italic">{{ $history->notes }}</div> @endif
                            @if ($history->changedBy) <div class="text-xs text-slate-400">by {{ $history->changedBy->name }}</div> @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
