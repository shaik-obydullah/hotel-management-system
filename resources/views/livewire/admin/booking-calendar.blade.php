<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Booking Calendar</h1>
            <p class="text-slate-500 text-sm mt-1">Arrivals and departures overview</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="prevMonth" class="btn-secondary text-sm px-3 py-2">←</button>
            <span class="font-bold w-40 text-center">{{ $start->format('F Y') }}</span>
            <button wire:click="nextMonth" class="btn-secondary text-sm px-3 py-2">→</button>
            <button wire:click="goToday" class="btn-ghost text-sm">Today</button>
        </div>
    </div>

    <div class="card mt-6 p-4 overflow-x-auto">
        <div class="grid grid-cols-7 gap-1 min-w-[900px]">
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d)
                <div class="text-center text-xs font-semibold text-slate-500 py-2 uppercase">{{ $d }}</div>
            @endforeach

            @for ($i = 0; $i < $startWeekday; $i++)
                <div class="h-28 bg-slate-50 rounded-lg"></div>
            @endfor

            @foreach ($days as $day)
                @php
                    $dayBookings = $bookings->filter(fn ($b) => $b->check_in_date->isSameDay($day) || $b->check_out_date->isSameDay($day));
                @endphp
                <div class="min-h-28 rounded-lg border border-slate-100 p-1.5 {{ $day->isToday() ? 'bg-indigo-50 border-indigo-200' : '' }}">
                    <div class="text-xs font-semibold {{ $day->isToday() ? 'text-indigo-600' : 'text-slate-500' }}">{{ $day->day }}</div>
                    <div class="mt-1 space-y-1">
                        @foreach ($dayBookings as $booking)
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                               class="block rounded px-1.5 py-0.5 text-[10px] leading-tight truncate {{ $booking->check_in_date->isSameDay($day) ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}"
                               title="{{ $booking->guest->name }} — Room {{ $booking->room->room_number }}">
                                {{ $booking->room->room_number }} · {{ $booking->guest->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex gap-4 mt-4 text-xs text-slate-600">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-100 border border-blue-200"></span> Check-in</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-amber-100 border border-amber-200"></span> Check-out</span>
        </div>
    </div>
</div>
