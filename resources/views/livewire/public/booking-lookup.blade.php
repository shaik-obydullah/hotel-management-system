<div>
    <section wire:ignore class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
            <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-2">Guest services</p>
            <h1 class="text-3xl lg:text-4xl font-extrabold">Find my booking</h1>
            <p class="mt-2 text-slate-300">Enter your booking number and the email used at booking time.</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
    <div class="max-w-2xl mx-auto mt-2">
    <form wire:submit="search" class="card p-6">
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="label">Booking number</label>
                <input type="text" wire:model="booking_number" class="input" placeholder="GAZ-20260801-1234">
                @error('booking_number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="label">Email used at booking</label>
                <input type="email" wire:model="email" class="input" placeholder="john@example.com">
                @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">Find booking</button>
            </div>
        </div>
    </form>

    @if ($searched && $error)
        <div class="mt-6 rounded-lg bg-rose-50 border border-rose-200 p-4 text-sm text-rose-700">{{ $error }}</div>
    @endif

    @if ($result)
        <div class="card mt-6 overflow-hidden">
            <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="text-xs text-slate-500 uppercase">Booking</div>
                    <div class="text-xl font-bold text-indigo-600">{{ $result->booking_number }}</div>
                </div>
                <span class="badge {{ $result->status->color() }}">{{ $result->status->label() }}</span>
            </div>
            <div class="p-6 grid sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <div class="text-xs text-slate-500 uppercase mb-1">Guest</div>
                    <div class="font-semibold">{{ $result->guest->name }}</div>
                    <div class="text-slate-500">{{ $result->guest->email }}</div>
                    <div class="text-slate-500">{{ $result->guest->phone }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase mb-1">Room</div>
                    <div class="font-semibold">Room {{ $result->room->room_number }} — {{ $result->room->roomType->name }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase mb-1">Stay</div>
                    <div class="font-semibold">{{ $result->check_in_date->format('M d, Y') }} → {{ $result->check_out_date->format('M d, Y') }}</div>
                    <div class="text-slate-500">{{ $result->nights }} night(s) · {{ $result->adults }} adult(s){{ $result->children ? ', '.$result->children.' child(ren)' : '' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase mb-1">Total</div>
                    <div class="font-bold text-lg">{{ money($result->total_amount) }}</div>
                    <div class="text-slate-500">{{ $result->source->label() }} booking</div>
                </div>
            </div>
            <div class="px-6 pb-6">
                <a href="{{ route('booking.show', $result->booking_number) }}" class="btn-secondary">View full details →</a>
            </div>
        </div>
    @endif
    </div>
    </div>
</div>
