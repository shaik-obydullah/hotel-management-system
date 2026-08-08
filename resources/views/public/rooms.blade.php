@extends('layouts.app')

@section('content')
    <section class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
            <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-2">Accommodation</p>
            <h1 class="text-3xl lg:text-4xl font-extrabold">Rooms &amp; Suites</h1>
            <p class="mt-2 text-slate-300">Explore our accommodation options below.</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">

        <div class="grid gap-8 md:grid-cols-2 mt-2">
            @forelse ($roomTypes as $type)
                <div class="card overflow-hidden">
                    <div class="h-52 bg-gradient-to-br {{ $loop->iteration % 2 ? 'from-indigo-500 to-violet-600' : 'from-teal-500 to-emerald-600' }} relative">
                        <span class="absolute bottom-4 left-4 badge bg-white/90 text-slate-800">{{ $type->rooms_count }} room(s)</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold">{{ $type->name }}</h2>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $type->bed_type ? $type->bed_type.' · ' : '' }}{{ $type->size_sqft ? $type->size_sqft.' sqft · ' : '' }}Up to {{ $type->max_guests }} guests
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-2xl font-bold text-indigo-600">{{ money($type->base_price) }}</div>
                                <div class="text-xs text-slate-500">per night</div>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">{{ $type->description }}</p>
                        @if (!empty($type->amenities))
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($type->amenities as $amenity)
                                    <span class="badge bg-slate-100 text-slate-700">{{ $amenity }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('availability', ['room_type' => $type->id]) }}" class="btn-primary mt-5 w-full">Check availability</a>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 col-span-full">No room types published yet.</p>
            @endforelse
        </div>
    </div>
@endsection
