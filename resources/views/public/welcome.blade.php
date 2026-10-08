@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <section class="relative bg-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 20%, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-10 items-center">
            <div>
                <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-3">{{ $hotel->tagline ?? 'Boutique hospitality' }}</p>
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight">Stay at {{ $hotel->name ?? 'our hotel' }}</h1>
                <p class="mt-4 text-slate-300 text-lg max-w-lg">
                    Check availability in real time and reserve the perfect room for your stay.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#availability" class="btn-primary">Check Availability</a>
                    <a href="{{ route('rooms') }}" class="inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold transition cursor-pointer text-white border border-white/40 hover:bg-white hover:text-indigo-700 hover:border-white">View Rooms &amp; Suites</a>
                </div>
                <div class="mt-10 flex gap-8 text-sm">
                    <div>
                        <div class="text-2xl font-bold text-white">{{ $roomTypes->sum(fn ($t) => $t->rooms_count ?? 0) }}</div>
                        <div class="text-slate-400">Rooms</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-slate-400">Reception</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">{{ count($roomTypes) }}</div>
                        <div class="text-slate-400">Room Types</div>
                    </div>
                </div>
            </div>

            <div id="availability" class="card bg-white text-slate-900 p-6 shadow-2xl">
                <h2 class="text-lg font-bold mb-1">Find your room</h2>
                <p class="text-sm text-slate-500 mb-5">Search availability without signing in.</p>
                <form method="GET" action="{{ route('availability') }}" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Check-in</label>
                            <input type="date" name="check_in" value="{{ \Carbon\Carbon::today()->addDay()->toDateString() }}" min="{{ \Carbon\Carbon::today()->toDateString() }}" class="input" required>
                        </div>
                        <div>
                            <label class="label">Check-out</label>
                            <input type="date" name="check_out" value="{{ \Carbon\Carbon::today()->addDays(3)->toDateString() }}" min="{{ \Carbon\Carbon::today()->addDay()->toDateString() }}" class="input" required>
                        </div>
                        <div>
                            <label class="label">Adults</label>
                            <select name="adults" class="input">
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ $i === 2 ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="label">Children</label>
                            <select name="children" class="input">
                                @for ($i = 0; $i <= 4; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary w-full">Search available rooms</button>
                </form>
            </div>
        </div>
    </section>

    {{-- Room types --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold">Rooms &amp; Suites</h2>
                <p class="text-slate-500 mt-1">Comfortable stays for every traveler</p>
            </div>
            <a href="{{ route('rooms') }}" class="text-indigo-600 text-sm font-semibold hover:underline">View all</a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($roomTypes as $type)
                <div class="card overflow-hidden group">
                    <div class="h-40 bg-gradient-to-br {{ $loop->iteration % 2 ? 'from-indigo-500 to-violet-600' : 'from-teal-500 to-emerald-600' }} flex items-center justify-center text-white text-4xl">
                        🛏
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold">{{ $type->name }}</h3>
                        <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $type->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-indigo-600">{{ money($type->base_price) }}</span>
                                <span class="text-xs text-slate-500">/ night</span>
                            </div>
                            <a href="{{ route('availability', ['room_type' => $type->id]) }}" class="btn-primary text-xs">Check →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-slate-500">No rooms published yet.</p>
            @endforelse
        </div>
    </section>

    {{-- Amenities strip --}}
    <section class="bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-2xl mb-1">📶</div>
                <div class="font-semibold text-sm">Free Wi-Fi</div>
                <div class="text-xs text-slate-500">High-speed internet everywhere</div>
            </div>
            <div>
                <div class="text-2xl mb-1">🏊</div>
                <div class="font-semibold text-sm">Swimming Pool</div>
                <div class="text-xs text-slate-500">Outdoor pool &amp; deck</div>
            </div>
            <div>
                <div class="text-2xl mb-1">🍳</div>
                <div class="font-semibold text-sm">Breakfast Included</div>
                <div class="text-xs text-slate-500">Daily breakfast buffet</div>
            </div>
            <div>
                <div class="text-2xl mb-1">🚗</div>
                <div class="font-semibold text-sm">Free Parking</div>
                <div class="text-xs text-slate-500">Secure on-site parking</div>
            </div>
        </div>
    </section>
@endsection
