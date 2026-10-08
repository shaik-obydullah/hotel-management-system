<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">{{ $guest->name }} @if ($guest->vip_status) <span class="badge bg-amber-100 text-amber-800 ml-1">VIP</span> @endif</h1>
            <p class="text-slate-500 text-sm mt-1">Guest profile</p>
        </div>
        <a href="{{ route('admin.guests') }}" class="btn-ghost">← All guests</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mt-6">
        <div class="space-y-6">
            <div class="card p-5">
                <h2 class="font-bold mb-3">Contact details</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Email</span><span>{{ $guest->email ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Phone</span><span>{{ $guest->phone ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Nationality</span><span>{{ $guest->nationality ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Address</span><span>{{ $guest->address ?? '—' }}{{ $guest->city ? ', '.$guest->city : '' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Country</span><span>{{ $guest->country ?? '—' }}</span></div>
                </div>
            </div>
            <div class="card p-5">
                <h2 class="font-bold mb-3">Identification</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">ID type</span><span>{{ $guest->id_type ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">ID number</span><span>{{ $guest->id_number ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Loyalty points</span><span class="font-semibold text-amber-600">{{ $guest->loyalty_points }}</span></div>
                </div>
            </div>
            @if ($guest->notes)
                <div class="card p-5">
                    <h2 class="font-bold mb-3">Notes</h2>
                    <p class="text-sm text-slate-600">{{ $guest->notes }}</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2 card overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 bg-slate-50"><h2 class="font-bold">Booking history ({{ $this->bookings->count() }})</h2></div>
            <table class="table-wrap">
                <thead>
                    <tr>
                        <th class="table-th">Booking #</th>
                        <th class="table-th">Room</th>
                        <th class="table-th">Dates</th>
                        <th class="table-th">Total</th>
                        <th class="table-th">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->bookings as $booking)
                        <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('admin.bookings.show', $booking) }}'">
                            <td class="table-td font-medium text-indigo-600">{{ $booking->booking_number }}</td>
                            <td class="table-td">{{ $booking->room->room_number }} · {{ $booking->room->roomType->name }}</td>
                            <td class="table-td">
                                <div>{{ $booking->check_in_date->format('M d, Y') }} → {{ $booking->check_out_date->format('M d, Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->nights }} night(s)</div>
                            </td>
                            <td class="table-td font-semibold">{{ money($booking->total_amount) }}</td>
                            <td class="table-td"><span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="table-td text-center text-slate-400 py-8">No bookings for this guest yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
