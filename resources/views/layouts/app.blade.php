<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? ($hotel->name ?? 'Hotel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">
    @php($hotel = $hotel ?? \App\Models\HotelInfo::current())
    <header x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold">H</span>
                    <span class="text-lg font-bold text-slate-900">{{ $hotel->name ?? 'Hotel' }}</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Home</a>
                    <a href="{{ route('rooms') }}" class="{{ request()->routeIs('rooms') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Rooms &amp; Suites</a>
                    <a href="{{ route('availability') }}" class="{{ request()->routeIs('availability') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Check Availability</a>
                    <a href="{{ route('booking.lookup') }}" class="{{ request()->routeIs('booking.lookup') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">My Booking</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Contact</a>
                </nav>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.login') }}" class="hidden sm:inline-flex btn-secondary">Staff Login</a>
                    <button class="md:hidden text-slate-600" @click="open = !open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="md:hidden border-t border-slate-200 bg-white">
            <nav x-show="open" x-cloak x-transition class="px-4 py-3 space-y-2 text-sm font-medium">
                <a href="{{ route('home') }}" class="block text-slate-600">Home</a>
                <a href="{{ route('rooms') }}" class="block text-slate-600">Rooms &amp; Suites</a>
                <a href="{{ route('availability') }}" class="block text-slate-600">Check Availability</a>
                <a href="{{ route('booking.lookup') }}" class="block text-slate-600">My Booking</a>
                <a href="{{ route('contact') }}" class="block text-slate-600">Contact</a>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 grid gap-8 md:grid-cols-3">
            <div>
                <div class="text-white font-bold text-lg mb-2">{{ $hotel->name ?? 'Hotel' }}</div>
                <p class="text-sm text-slate-400">{{ $hotel->tagline ?? 'Luxury hospitality, crafted for you.' }}</p>
            </div>
            <div>
                <div class="text-white font-semibold mb-3">Contact</div>
                <address class="text-sm text-slate-400 not-italic space-y-1">
                    <div>@if($hotel->address) {{ $hotel->address }}{{ $hotel->city ? ', '.$hotel->city : '' }} @endif{{ $hotel->country ? ', '.$hotel->country : '' }}</div>
                    @if($hotel->phone)<div>{{ $hotel->phone }}</div>@endif
                    @if($hotel->email)<div>{{ $hotel->email }}</div>@endif
                </address>
            </div>
            <div>
                <div class="text-white font-semibold mb-3">Check-in / Check-out</div>
                <p class="text-sm text-slate-400">
                    Check-in {{ \Carbon\Carbon::parse($hotel->check_in_time ?? '14:00')->format('g:i A') }} &nbsp;·&nbsp;
                    Check-out {{ \Carbon\Carbon::parse($hotel->check_out_time ?? '11:00')->format('g:i A') }}
                </p>
            </div>
        </div>
        <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} {{ $hotel->name ?? 'Hotel' }}. All rights reserved.
        </div>
    </footer>

    @livewireScripts
</body>
</html>
