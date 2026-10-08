<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} · Admin · {{ auth()->user()?->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="min-h-screen lg:flex">
        <aside x-show="sidebarOpen" x-cloak x-transition class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col lg:static lg:translate-x-0">
            <div class="h-16 flex items-center gap-2 px-5 border-b border-slate-800">
                <span class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center font-bold text-sm">H</span>
                <div>
                    <div class="text-white font-bold text-sm leading-tight">{{ \App\Models\HotelInfo::current()->name }}</div>
                    <div class="text-[11px] text-slate-500">Admin Panel</div>
                </div>
            </div>
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-sm">
                @php
                    $nav = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
                        ['label' => 'Bookings', 'route' => 'admin.bookings', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['label' => 'Booking Calendar', 'route' => 'admin.bookings.calendar', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['label' => 'New Booking', 'route' => 'admin.bookings.create', 'icon' => 'M12 4v16m8-8H4'],
                        ['label' => 'Rooms', 'route' => 'admin.rooms', 'icon' => 'M3 7l9-4 9 4v10l-9 4-9-4V7zm18 0l-9 4M3 7l9 4m9 0l-9 4M3 11l9 4m9 0l-9 4'],
                        ['label' => 'Room Types', 'route' => 'admin.room-types', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                        ['label' => 'Guests', 'route' => 'admin.guests', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['label' => 'Invoices & Payments', 'route' => 'admin.invoices', 'icon' => 'M9 14l6-6m-5.5 8h5M9 12l2-2M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z'],
                        ['label' => 'Housekeeping', 'route' => 'admin.housekeeping', 'icon' => 'M3 21h18M4 21V8l8-4 8 4v13M8 21v-7h8v7'],
                        ['label' => 'Services', 'route' => 'admin.services', 'icon' => 'M12 8c-2 0-3 1-3 2s1 2 3 2 3 1 3 2-1 2-3 2m0-8c0-.5.3-1 1-1m-1 9c0 .5.3 1 1 1m4-9a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Reports', 'route' => 'admin.reports', 'icon' => 'M3 3v18h18M8 17V9m5 8V5m5 12v-4'],
                        ['label' => 'Staff', 'route' => 'admin.staff', 'icon' => 'M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.75-.19-1.46-.52-2.07M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-1.1.4-2.1 1.1-2.9M14 7a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'M10.3 3.9a2 2 0 013.4 0l.8 1.2a2 2 0 002.3.7l1.4-.4a2 2 0 012.6 2.6l-.4 1.4a2 2 0 00.7 2.3l1.2.8a2 2 0 010 3.4l-1.2.8a2 2 0 00-.7 2.3l.4 1.4a2 2 0 01-2.6 2.6l-1.4-.4a2 2 0 00-2.3.7l-.8 1.2a2 2 0 01-3.4 0l-.8-1.2a2 2 0 00-2.3-.7l-1.4.4a2 2 0 01-2.6-2.6l.4-1.4a2 2 0 00-.7-2.3l-1.2-.8a2 2 0 010-3.4l1.2-.8a2 2 0 00.7-2.3l-.4-1.4a2 2 0 012.6-2.6l1.4.4a2 2 0 002.3-.7l.8-1.2zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ];
                @endphp
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate
                       class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs($item['route']) ? 'bg-indigo-600 text-white font-medium' : 'hover:bg-slate-800 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm hover:bg-slate-800 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"></div>

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center gap-4 px-4 sm:px-6">
                <button class="lg:hidden text-slate-600" @click="sidebarOpen = !sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="text-sm text-slate-500">{{ \Illuminate\Support\Str::headline(request()->segment(2) ?? 'Dashboard') }}</div>
                <div class="ml-auto flex items-center gap-3">
                    @php $user = auth()->user(); @endphp
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-semibold text-slate-800">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500 capitalize">{{ $user->roles->pluck('name')->join(', ') }}</div>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
