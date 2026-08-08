<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">New Booking</h1>
            <p class="text-slate-500 text-sm mt-1">Walk-in or phone reservation</p>
        </div>
        <a href="{{ route('admin.bookings') }}" class="btn-ghost">← All bookings</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mt-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Stay --}}
            <div class="card p-6">
                <h2 class="font-bold mb-4">1 · Stay details</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="label">Check-in *</label>
                        <input type="date" wire:model.live="check_in" class="input">
                        @error('check_in') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Check-out *</label>
                        <input type="date" wire:model.live="check_out" class="input">
                        @error('check_out') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Adults *</label>
                        <input type="number" wire:model="adults" min="1" max="10" class="input">
                    </div>
                    <div>
                        <label class="label">Children</label>
                        <input type="number" wire:model="children" min="0" max="10" class="input">
                    </div>
                </div>
            </div>

            {{-- Guest --}}
            <div class="card p-6">
                <h2 class="font-bold mb-4">2 · Guest</h2>
                @if ($guest_id && ! $creatingGuest)
                    <div class="flex items-center justify-between rounded-lg bg-emerald-50 border border-emerald-200 p-3">
                        <div>
                            <div class="font-semibold">{{ \App\Models\Guest::find($guest_id)?->name }}</div>
                            <div class="text-xs text-slate-500">{{ \App\Models\Guest::find($guest_id)?->email }} · {{ \App\Models\Guest::find($guest_id)?->phone }}</div>
                        </div>
                        <button wire:click="changeGuest" class="text-xs text-rose-600 hover:underline">Change</button>
                    </div>
                @endif

                @if (! $guest_id && ! $creatingGuest)
                    <div>
                        <label class="label">Search existing guest</label>
                        <input type="text" wire:model.live.debounce.300ms="guest_query" class="input" placeholder="Type name, email or phone…">
                        @if ($this->guestResults->isNotEmpty())
                            <div class="mt-2 rounded-lg border border-slate-200 divide-y divide-slate-100 max-h-56 overflow-y-auto">
                                @foreach ($this->guestResults as $g)
                                    <button wire:click="selectGuest({{ $g->id }})" class="w-full text-left px-4 py-2.5 hover:bg-slate-50 flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-sm">{{ $g->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $g->email }} · {{ $g->phone }}</div>
                                        </div>
                                        <span class="text-xs text-indigo-600">Select →</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        <button wire:click="$set('creatingGuest', true)" class="text-sm text-indigo-600 hover:underline mt-3">+ Create a new guest instead</button>
                        @error('guest_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                @endif

                @if ($creatingGuest)
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Full name *</label>
                            <input type="text" wire:model="g_name" class="input">
                            @error('g_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Phone *</label>
                            <input type="text" wire:model="g_phone" class="input">
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" wire:model="g_email" class="input">
                        </div>
                        <div>
                            <label class="label">Nationality</label>
                            <input type="text" wire:model="g_nationality" class="input">
                        </div>
                        <div>
                            <label class="label">ID type</label>
                            <input type="text" wire:model="g_id_type" class="input" placeholder="Passport">
                        </div>
                        <div>
                            <label class="label">ID number</label>
                            <input type="text" wire:model="g_id_number" class="input">
                        </div>
                        <div>
                            <label class="label">Address</label>
                            <input type="text" wire:model="g_address" class="input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">City</label>
                                <input type="text" wire:model="g_city" class="input">
                            </div>
                            <div>
                                <label class="label">Country</label>
                                <input type="text" wire:model="g_country" class="input">
                            </div>
                        </div>
                        <div class="sm:col-span-2 flex gap-2">
                            <button wire:click="createGuest" class="btn-primary">Save guest</button>
                            <button wire:click="$set('creatingGuest', false)" class="btn-secondary">Cancel</button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Room --}}
            <div class="card p-6">
                <h2 class="font-bold mb-4">3 · Room</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <label class="label">Room type *</label>
                        <select wire:model.live="room_type_id" class="input">
                            <option value="">Select room type…</option>
                            @foreach ($this->roomTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} — {{ money($type->base_price) }}/night</option>
                            @endforeach
                        </select>
                        @error('room_type_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="lg:col-span-2">
                        <label class="label">Available rooms</label>
                        @if ($this->availableRooms->isEmpty() && $room_type_id)
                            <div class="rounded-lg bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">No rooms available for the selected dates.</div>
                        @elseif ($this->availableRooms->isEmpty())
                            <div class="rounded-lg bg-slate-50 border border-slate-200 p-3 text-sm text-slate-500">Select a room type and dates.</div>
                        @else
                            <select wire:model="room_id" class="input">
                                <option value="">Choose room…</option>
                                @foreach ($this->availableRooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->room_number }} (Floor {{ $room->floor->number }})</option>
                                @endforeach
                            </select>
                            @error('room_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        @endif
                    </div>
                    <div>
                        <label class="label">Discount</label>
                        <input type="number" step="0.01" min="0" wire:model.live="discount" class="input" placeholder="0.00">
                    </div>
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="label">Special requests</label>
                        <textarea wire:model="special_requests" rows="2" class="input"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="card p-6 h-fit sticky top-24">
            <h2 class="font-bold text-lg mb-4">Summary</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Nights</span>
                    <span class="font-semibold">{{ $this->price['nights'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Room nights</span>
                    <span class="font-semibold">{{ money($this->price['subtotal']) }}</span>
                </div>
                @if ((float) $this->discount > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span>Discount</span>
                        <span>-{{ money($this->price['discount']) }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-slate-600">Tax</span>
                    <span class="font-semibold">{{ money($this->price['tax']) }}</span>
                </div>
                <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-bold">
                    <span>Total</span>
                    <span class="text-indigo-600">{{ money($this->price['total']) }}</span>
                </div>
            </div>
            <button wire:click="submit" wire:loading.attr="disabled" class="btn-primary w-full mt-6">
                <span wire:loading.remove wire:target="submit">Create booking</span>
                <span wire:loading wire:target="submit">Creating…</span>
            </button>
        </div>
    </div>
</div>
