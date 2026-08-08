<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Bookings</h1>
            <p class="text-slate-500 text-sm mt-1">All reservations</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="btn-primary">+ New booking</a>
    </div>

    <div class="card mt-6 p-4">
        <div class="grid gap-3 lg:grid-cols-6">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search number, guest, email, phone…" class="input lg:col-span-2">
            <select wire:model.live="statusFilter" class="input">
                <option value="">All statuses</option>
                @foreach (\App\Enums\BookingStatus::options() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <select wire:model.live="sourceFilter" class="input">
                <option value="">All sources</option>
                @foreach (\App\Enums\BookingSource::cases() as $source)
                    <option value="{{ $source->value }}">{{ $source->label() }}</option>
                @endforeach
            </select>
            <input type="date" wire:model.live="dateFrom" class="input" title="Check-in from">
            <input type="date" wire:model.live="dateTo" class="input" title="Check-in until">
        </div>
        <button wire:click="resetFilters" class="text-xs text-indigo-600 hover:underline mt-3">Clear filters</button>
    </div>

    <div class="card mt-4 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Booking #</th>
                    <th class="table-th">Guest</th>
                    <th class="table-th">Room</th>
                    <th class="table-th">Dates</th>
                    <th class="table-th">Total</th>
                    <th class="table-th">Source</th>
                    <th class="table-th">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->bookings as $booking)
                    <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('admin.bookings.show', $booking) }}'">
                        <td class="table-td font-medium text-indigo-600">{{ $booking->booking_number }}</td>
                        <td class="table-td">
                            <div class="font-medium">{{ $booking->guest->name }}</div>
                            <div class="text-xs text-slate-500">{{ $booking->guest->email }}</div>
                        </td>
                        <td class="table-td">Room {{ $booking->room->room_number }}</td>
                        <td class="table-td">
                            <div>{{ $booking->check_in_date->format('M d') }} → {{ $booking->check_out_date->format('M d, Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $booking->nights }} night(s)</div>
                        </td>
                        <td class="table-td font-semibold">{{ money($booking->total_amount) }}</td>
                        <td class="table-td text-xs">{{ $booking->source->label() }}</td>
                        <td class="table-td"><span class="badge {{ $booking->status->color() }}">{{ $booking->status->label() }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="table-td text-center text-slate-400 py-8">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $this->bookings->links() }}</div>
    </div>
</div>
