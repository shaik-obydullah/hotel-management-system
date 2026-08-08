<div>
    <section wire:ignore class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
            <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-2">Availability</p>
            <h1 class="text-3xl lg:text-4xl font-extrabold">Check Availability</h1>
            <p class="mt-2 text-slate-300">Select your dates to see which rooms are available.</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
    <div class="mt-2">
    <form wire:submit="search" class="card p-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div>
                <label class="label">Check-in</label>
                <input type="date" wire:model="check_in" min="{{ now()->toDateString() }}" class="input">
            </div>
            <div>
                <label class="label">Check-out</label>
                <input type="date" wire:model="check_out" min="{{ now()->addDay()->toDateString() }}" class="input">
            </div>
            <div>
                <label class="label">Adults</label>
                <select wire:model="adults" class="input">
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="label">Children</label>
                <select wire:model="children" class="input">
                    @for ($i = 0; $i <= 4; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">Search</button>
            </div>
        </div>
        @error('check_in') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        @error('check_out') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
    </form>

    @if ($error)
        <div class="mt-6 rounded-lg bg-rose-50 border border-rose-200 p-4 text-sm text-rose-700">{{ $error }}</div>
    @endif

    @if ($searched && ! $error)
        <div class="mt-8">
            <h2 class="text-lg font-bold">
                Available rooms for {{ \Carbon\Carbon::parse($check_in)->format('M d') }} → {{ \Carbon\Carbon::parse($check_out)->format('M d, Y') }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">{{ $adults }} adult(s), {{ $children }} child(ren) · {{ $this->summary->isEmpty() ? 0 : $this->summary->sum('nights') }} nights</p>

            <div class="mt-6 space-y-5">
                @forelse ($this->summary as $item)
                    <div class="card p-6 flex flex-col sm:flex-row sm:items-center gap-6">
                        <div class="h-24 w-full sm:w-36 shrink-0 rounded-xl bg-gradient-to-br {{ $loop->iteration % 2 ? 'from-indigo-500 to-violet-600' : 'from-teal-500 to-emerald-600' }} flex items-center justify-center text-white text-3xl">🛏</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-bold text-lg">{{ $item->room_type->name }}</h3>
                                <span class="badge {{ $item->available > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $item->available > 0 ? $item->available.' available' : 'Fully booked' }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $item->room_type->description }}</p>
                            <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">
                                <span class="badge bg-slate-100 text-slate-700">👤 Up to {{ $item->room_type->max_guests }}</span>
                                @if ($item->room_type->bed_type) <span class="badge bg-slate-100 text-slate-700">🛏 {{ $item->room_type->bed_type }}</span> @endif
                                @if ($item->room_type->size_sqft) <span class="badge bg-slate-100 text-slate-700">📐 {{ $item->room_type->size_sqft }} sqft</span> @endif
                            </div>
                        </div>
                        <div class="sm:text-right sm:border-l sm:border-slate-100 sm:pl-6">
                            <div class="text-2xl font-bold text-indigo-600">{{ money($item->rate) }}</div>
                            <div class="text-xs text-slate-500">/ night · {{ $item->nights }} nights</div>
                            <div class="text-sm text-slate-600 mt-1">≈ {{ money($item->subtotal) }} + tax</div>
                            @if ($item->available > 0)
                                <a href="{{ route('booking', ['check_in' => $check_in, 'check_out' => $check_out, 'room_type' => $item->room_type->id, 'adults' => $adults, 'children' => $children]) }}" class="btn-primary mt-4">Book now →</a>
                            @else
                                <div class="mt-4"><span class="btn-secondary cursor-not-allowed opacity-60">Unavailable</span></div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card p-10 text-center">
                        <div class="text-4xl mb-3">😔</div>
                        <p class="font-semibold">No rooms available for the selected dates.</p>
                        <p class="text-sm text-slate-500 mt-1">Try different dates or a smaller party.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
    </div>
    </div>
</div>
