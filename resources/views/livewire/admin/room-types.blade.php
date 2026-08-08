<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Room Types</h1>
            <p class="text-slate-500 text-sm mt-1">Categories, base pricing and amenities</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add room type</button>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mt-6">
        @forelse ($this->roomTypes as $type)
            <div class="card overflow-hidden">
                <div class="h-32 bg-gradient-to-br {{ $loop->iteration % 2 ? 'from-indigo-500 to-violet-600' : 'from-teal-500 to-emerald-600' }} flex items-center justify-center text-white text-3xl">🛏</div>
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $type->name }}</h2>
                        <span class="badge {{ $type->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">{{ $type->status }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $type->description }}</p>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <div class="font-bold text-indigo-600">{{ money($type->base_price) }}<span class="text-xs text-slate-400 font-normal">/night</span></div>
                        <div class="text-xs text-slate-500">{{ $type->rooms_count }} room(s)</div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button wire:click="openEdit({{ $type->id }})" class="btn-secondary flex-1 text-xs">Edit</button>
                        <button wire:click="delete({{ $type->id }})" wire:confirm="Delete this room type?" class="btn-ghost text-xs text-rose-600">Del</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-500 col-span-full">No room types yet.</p>
        @endforelse
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit room type' : 'Add room type' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Name *</label>
                            <input type="text" wire:model="name" class="input" placeholder="Deluxe Room">
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Base price / night *</label>
                            <input type="number" step="0.01" wire:model="base_price" class="input">
                            @error('base_price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Max guests *</label>
                            <input type="number" wire:model="max_guests" class="input">
                        </div>
                        <div>
                            <label class="label">Size (sqft)</label>
                            <input type="number" wire:model="size_sqft" class="input">
                        </div>
                        <div>
                            <label class="label">Bed type</label>
                            <input type="text" wire:model="bed_type" class="input" placeholder="King bed">
                        </div>
                        <div>
                            <label class="label">Status</label>
                            <select wire:model="status" class="input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="label">Description</label>
                            <textarea wire:model="description" rows="2" class="input"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="label">Amenities (comma separated)</label>
                            <input type="text" wire:model="amenities" class="input" placeholder="Free Wi-Fi, Air conditioning, Mini bar, Sea view">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save room type</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
