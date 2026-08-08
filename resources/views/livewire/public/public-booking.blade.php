<div>
    <section wire:ignore class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
            <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-2">Reservation</p>
            <h1 class="text-3xl lg:text-4xl font-extrabold">Complete your booking</h1>
            <p class="mt-2 text-slate-300">Fill in your details to confirm your stay.</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
    <div class="max-w-3xl mx-auto mt-2">
    @if ($unavailable)
        <div class="card p-10 text-center">
            <div class="text-4xl mb-3">😔</div>
            <p class="font-semibold">No room type selected.</p>
            <p class="text-sm text-slate-500 mt-1">Please choose a room type first.</p>
            <a href="{{ route('availability') }}" class="btn-primary mt-5">Check availability</a>
        </div>
    @else
        <div class="grid lg:grid-cols-5 gap-6">
            <div class="lg:col-span-3 space-y-6">
                <div class="card p-6">
                    <h2 class="font-bold text-lg mb-4">Your stay</h2>
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="h-28 w-full sm:w-44 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-3xl">🛏</div>
                        <div class="flex-1">
                            <div class="font-bold text-xl">{{ $this->roomType->name }}</div>
                            <div class="text-sm text-slate-500 mt-1">{{ $this->roomType->description }}</div>
                            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                <span class="badge bg-slate-100 text-slate-700">👤 Up to {{ $this->roomType->max_guests }} guests</span>
                                @if ($this->roomType->bed_type) <span class="badge bg-slate-100 text-slate-700">🛏 {{ $this->roomType->bed_type }}</span> @endif
                                @if ($this->roomType->size_sqft) <span class="badge bg-slate-100 text-slate-700">📐 {{ $this->roomType->size_sqft }} sqft</span> @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 grid sm:grid-cols-2 gap-4 bg-slate-50 rounded-xl p-4 text-sm">
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Check-in</div>
                            <div class="font-semibold">{{ \Carbon\Carbon::parse($check_in)->format('D, M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Check-out</div>
                            <div class="font-semibold">{{ \Carbon\Carbon::parse($check_out)->format('D, M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Guests</div>
                            <div class="font-semibold">{{ $adults }} adult(s){{ $children ? ', '.$children.' child(ren)' : '' }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Nights</div>
                            <div class="font-semibold">{{ count($this->rates) }} night(s)</div>
                        </div>
                    </div>
                    <a href="{{ route('availability', ['check_in' => $check_in, 'check_out' => $check_out, 'adults' => $adults, 'children' => $children, 'room_type' => $room_type]) }}" class="text-sm text-indigo-600 hover:underline mt-4 inline-block">← Change dates or room</a>
                </div>

                <div class="card p-6">
                    <h2 class="font-bold text-lg mb-4">Your details</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Full name *</label>
                            <input type="text" wire:model="name" class="input" placeholder="John Doe">
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Email *</label>
                            <input type="email" wire:model="email" class="input" placeholder="john@example.com">
                            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Phone *</label>
                            <input type="text" wire:model="phone" class="input" placeholder="+1 555 000 1234">
                            @error('phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Nationality</label>
                            <input type="text" wire:model="nationality" class="input" placeholder="Country">
                        </div>
                        <div>
                            <label class="label">ID type</label>
                            <input type="text" wire:model="id_type" class="input" placeholder="Passport / Driver's license">
                        </div>
                        <div>
                            <label class="label">ID number</label>
                            <input type="text" wire:model="id_number" class="input" placeholder="ID number">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="label">Special requests</label>
                            <textarea wire:model="special_requests" rows="3" class="input" placeholder="Late arrival, extra pillows, airport transfer..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="card p-6 sticky top-20">
                    <h2 class="font-bold text-lg mb-4">Price summary</h2>
                    <div class="space-y-2 text-sm">
                        @foreach ($this->rates as $date => $rate)
                            <div class="flex justify-between">
                                <span class="text-slate-600">{{ \Carbon\Carbon::parse($date)->format('D, M d') }}</span>
                                <span class="font-medium">{{ money($rate) }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between border-t border-slate-200 pt-3">
                            <span class="text-slate-600">Subtotal ({{ count($this->rates) }} nights)</span>
                            <span class="font-semibold">{{ money($this->price['subtotal']) }}</span>
                        </div>
                        @if ((float) $this->price['discount'] > 0)
                            <div class="flex justify-between text-emerald-600">
                                <span>Discount</span>
                                <span>-{{ money($this->price['discount']) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tax ({{ $this->taxRate }}%)</span>
                            <span class="font-semibold">{{ money($this->price['tax']) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-bold">
                            <span>Total</span>
                            <span class="text-indigo-600">{{ money($this->price['total']) }}</span>
                        </div>
                    </div>

                    @error('room_type') <p class="mt-3 text-sm text-rose-600">{{ $message }}</p> @enderror

                    <button wire:click="submit" wire:loading.attr="disabled" class="btn-emerald w-full mt-6">
                        <span wire:loading.remove wire:target="submit">Confirm booking</span>
                        <span wire:loading wire:target="submit">Booking…</span>
                    </button>
                    <p class="text-xs text-slate-400 mt-3 text-center">No payment needed today. You will receive a confirmation with your booking number.</p>
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>
</div>
