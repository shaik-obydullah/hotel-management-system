<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Floors</h1>
            <p class="text-slate-500 text-sm mt-1">Organize rooms by floor</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add floor</button>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mt-6">
        @forelse ($this->floors as $floor)
            <div class="card p-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">{{ $floor->number }}</div>
                    <div>
                        <div class="font-bold">{{ $floor->name }}</div>
                        <div class="text-xs text-slate-500">{{ $floor->rooms_count }} room(s)</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button wire:click="openEdit({{ $floor->id }})" class="btn-ghost text-xs px-2 py-1">Edit</button>
                    <button wire:click="delete({{ $floor->id }})" wire:confirm="Delete this floor?" class="btn-ghost text-xs px-2 py-1 text-rose-600">Del</button>
                </div>
            </div>
        @empty
            <p class="text-slate-500 col-span-full">No floors yet.</p>
        @endforelse
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit floor' : 'Add floor' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Floor name *</label>
                            <input type="text" wire:model="name" class="input" placeholder="1st Floor">
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Floor number *</label>
                            <input type="number" wire:model="number" class="input">
                            @error('number') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save floor</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
