<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="btn-primary">+ New booking</a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">Occupancy today</div>
                <span class="text-xl">🏨</span>
            </div>
            <div class="text-3xl font-bold mt-2">{{ $this->stats['occupancy']['rate'] }}%</div>
            <div class="text-xs text-slate-500 mt-1">{{ $this->stats['occupancy']['occupied'] }} / {{ $this->stats['occupancy']['total_rooms'] }} rooms occupied</div>
            <div class="mt-3 h-2 rounded-full bg-slate-100 overflow-hidden">
                <div class="h-full bg-indigo-600 rounded-full" style="width: {{ min(100, $this->stats['occupancy']['rate']) }}%"></div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">Active bookings</div>
                <span class="text-xl">📅</span>
            </div>
            <div class="text-3xl font-bold mt-2">{{ $this->stats['active_bookings'] }}</div>
            <div class="text-xs text-slate-500 mt-1">Confirmed &amp; checked-in</div>
            <div class="mt-3 flex gap-2 text-xs">
                <span class="badge bg-blue-100 text-blue-800">{{ $this->stats['arrivals_today'] }} arriving today</span>
                <span class="badge bg-amber-100 text-amber-800">{{ $this->stats['departures_today'] }} departing</span>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">Revenue this month</div>
                <span class="text-xl">💰</span>
            </div>
            <div class="text-3xl font-bold mt-2">{{ money($this->stats['monthly_revenue']) }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $this->stats['monthly_bookings'] }} bookings this month</div>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="text-sm text-slate-500">Guests</div>
                <span class="text-xl">👥</span>
            </div>
            <div class="text-3xl font-bold mt-2">{{ $this->stats['total_guests'] }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $this->stats['pending_invoices'] }} invoices pending</div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="font-bold">Recent bookings</h2>
                <a href="{{ route('admin.bookings') }}" class="text-sm text-indigo-600 hover:underline">View all →</a>
            </div>
            <table class="table-wrap">
                <thead>
                    <tr>
                        <th class="table-th">Booking</th>
                        <th class="table-th">Guest</th>
                        <th class="table-th">Room</th>
                        <th class="table-th">Total</th>
                        <th class="table-th">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->recentBookings as $booking)
                        <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('admin.bookings.show', $booking) }}'">
                            <td class="table-td font-medium text-indigo-600">{{ $booking->booking_number }}</td>
                            <td class="table-td">{{ $booking->guest->name }}</td>
                            <td class="table-td">{{ $booking->room->room_number }}</td>
                            <td class="table-td">{{ money($booking->total_amount) }}</td>
                            <td class="table-td"><span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="table-td text-center text-slate-400 py-8">No bookings yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="space-y-6">
            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200"><h2 class="font-bold">Arrivals today</h2></div>
                <ul class="divide-y divide-slate-100">
                    @forelse ($this->arrivalsToday as $booking)
                        <li class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $booking->guest->name }}</div>
                                <div class="text-xs text-slate-500">Room {{ $booking->room->room_number }} · {{ $booking->nights }} night(s)</div>
                            </div>
                            <span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-6 text-center text-sm text-slate-400">No arrivals today.</li>
                    @endforelse
                </ul>
            </div>

            <div class="card overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200"><h2 class="font-bold">Departures today</h2></div>
                <ul class="divide-y divide-slate-100">
                    @forelse ($this->departuresToday as $booking)
                        <li class="px-5 py-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $booking->guest->name }}</div>
                                <div class="text-xs text-slate-500">Room {{ $booking->room->room_number }}</div>
                            </div>
                            <span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-6 text-center text-sm text-slate-400">No departures today.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
