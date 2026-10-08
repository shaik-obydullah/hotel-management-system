<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Rooms</h1>
            <p class="text-slate-500 text-sm mt-1">{{ \App\Models\Room::count() }} rooms registered</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add room</button>
    </div>

    <div class="card mt-6 p-4">
        <div class="grid gap-3 md:grid-cols-5">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search room number…" class="input md:col-span-2">
            <select wire:model.live="statusFilter" class="input">
                <option value="">All statuses</option>
                @foreach (\App\Enums\RoomStatus::options() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <select wire:model.live="typeFilter" class="input">
                <option value="">All types</option>
                @foreach ($this->roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="floorFilter" class="input">
                <option value="">All floors</option>
                @foreach ($this->floors as $floor)
                    <option value="{{ $floor->id }}">{{ $floor->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card mt-4 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Room</th>
                    <th class="table-th">Type</th>
                    <th class="table-th">Floor</th>
                    <th class="table-th">Rate / night</th>
                    <th class="table-th">Status</th>
                    <th class="table-th text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->rooms as $room)
                    <tr class="hover:bg-slate-50">
                        <td class="table-td font-bold">{{ $room->room_number }}</td>
                        <td class="table-td">{{ $room->roomType->name }}</td>
                        <td class="table-td">{{ $room->floor->name }}</td>
                        <td class="table-td">{{ money($room->roomType->base_price) }}</td>
                        <td class="table-td">
                            <span class="badge {{ $room->status->color() }}">{{ $room->status->label() }}</span>
                        </td>
                        <td class="table-td">
                            <div class="flex items-center justify-end gap-2">
                                <select wire:change="setStatus({{ $room->id }}, $event.target.value)" class="text-xs rounded-lg border-slate-300 py-1">
                                    @foreach (\App\Enums\RoomStatus::options() as $value => $label)
                                        <option value="{{ $value }}" {{ $room->status->value === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="openEdit({{ $room->id }})" class="btn-ghost text-xs px-2 py-1">Edit</button>
                                <button wire:click="delete({{ $room->id }})" wire:confirm="Delete this room?" class="btn-ghost text-xs px-2 py-1 text-rose-600">Del</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="table-td text-center text-slate-400 py-8">No rooms match your filters.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $this->rooms->links() }}</div>
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit room' : 'Add room' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Room number *</label>
                            <input type="text" wire:model="room_number" class="input" placeholder="101">
                            @error('room_number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Floor *</label>
                            <select wire:model="floor_id" class="input">
                                <option value="">Select floor…</option>
                                @foreach ($this->floors as $floor)
                                    <option value="{{ $floor->id }}">{{ $floor->name }}</option>
                                @endforeach
                            </select>
                            @error('floor_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Room type *</label>
                            <select wire:model="room_type_id" class="input">
                                <option value="">Select type…</option>
                                @foreach ($this->roomTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }} ({{ money($type->base_price) }}/night)</option>
                                @endforeach
                            </select>
                            @error('room_type_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Status *</label>
                            <select wire:model="status" class="input">
                                @foreach (\App\Enums\RoomStatus::options() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="label">Notes</label>
                            <textarea wire:model="notes" rows="2" class="input"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save room</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
