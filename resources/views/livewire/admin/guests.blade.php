<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Guests</h1>
            <p class="text-slate-500 text-sm mt-1">{{ \App\Models\Guest::count() }} guests registered</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add guest</button>
    </div>

    <div class="card mt-6 p-4">
        <div class="grid gap-3 md:grid-cols-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search name, email, phone, ID…" class="input md:col-span-2">
            <select wire:model.live="vipFilter" class="input">
                <option value="">All guests</option>
                <option value="vip">VIP only</option>
                <option value="regular">Regular only</option>
            </select>
        </div>
    </div>

    <div class="card mt-4 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Guest</th>
                    <th class="table-th">Contact</th>
                    <th class="table-th">Nationality</th>
                    <th class="table-th">Bookings</th>
                    <th class="table-th">VIP</th>
                    <th class="table-th text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->guests as $guest)
                    <tr class="hover:bg-slate-50">
                        <td class="table-td">
                            <a href="{{ route('admin.guests.show', $guest) }}" class="font-semibold text-indigo-600 hover:underline">{{ $guest->name }}</a>
                            @if ($guest->vip_status) <span class="badge bg-amber-100 text-amber-800 ml-1">VIP</span> @endif
                        </td>
                        <td class="table-td">
                            <div>{{ $guest->email }}</div>
                            <div class="text-xs text-slate-500">{{ $guest->phone }}</div>
                        </td>
                        <td class="table-td">{{ $guest->nationality ?? '—' }}</td>
                        <td class="table-td">{{ $guest->bookings_count }}</td>
                        <td class="table-td">
                            <button wire:click="toggleVip({{ $guest->id }})" class="text-xs {{ $guest->vip_status ? 'text-amber-600' : 'text-slate-400' }} hover:underline">{{ $guest->vip_status ? '★ VIP' : '☆ Mark VIP' }}</button>
                        </td>
                        <td class="table-td">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $guest->id }})" class="btn-ghost text-xs px-2 py-1">Edit</button>
                                <button wire:click="delete({{ $guest->id }})" wire:confirm="Delete this guest?" class="btn-ghost text-xs px-2 py-1 text-rose-600">Del</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="table-td text-center text-slate-400 py-8">No guests found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">{{ $this->guests->links() }}</div>
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit guest' : 'Add guest' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Full name *</label>
                            <input type="text" wire:model="name" class="input">
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Phone *</label>
                            <input type="text" wire:model="phone" class="input">
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" wire:model="email" class="input">
                        </div>
                        <div>
                            <label class="label">Nationality</label>
                            <input type="text" wire:model="nationality" class="input">
                        </div>
                        <div>
                            <label class="label">ID type</label>
                            <input type="text" wire:model="id_type" class="input" placeholder="Passport">
                        </div>
                        <div>
                            <label class="label">ID number</label>
                            <input type="text" wire:model="id_number" class="input">
                        </div>
                        <div>
                            <label class="label">Address</label>
                            <input type="text" wire:model="address" class="input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="label">City</label>
                                <input type="text" wire:model="city" class="input">
                            </div>
                            <div>
                                <label class="label">Country</label>
                                <input type="text" wire:model="country" class="input">
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="label">Notes</label>
                            <textarea wire:model="notes" rows="2" class="input"></textarea>
                        </div>
                        <div class="col-span-2 flex items-center gap-2">
                            <input type="checkbox" wire:model="vip_status" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                            <label class="text-sm text-slate-700">Mark as VIP</label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save guest</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
