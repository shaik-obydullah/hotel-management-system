<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Services &amp; Menu</h1>
            <p class="text-slate-500 text-sm mt-1">Charges added to guest bookings</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add service</button>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Service</th>
                    <th class="table-th">Category</th>
                    <th class="table-th">Price</th>
                    <th class="table-th">Status</th>
                    <th class="table-th text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->services as $service)
                    <tr class="hover:bg-slate-50">
                        <td class="table-td">
                            <div class="font-medium">{{ $service->name }}</div>
                            <div class="text-xs text-slate-500">{{ $service->description }}</div>
                        </td>
                        <td class="table-td"><span class="badge bg-slate-100 text-slate-700">{{ $service->category }}</span></td>
                        <td class="table-td font-semibold">{{ money($service->price) }}</td>
                        <td class="table-td">
                            <span class="badge {{ $service->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">{{ $service->status }}</span>
                        </td>
                        <td class="table-td">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $service->id }})" class="btn-ghost text-xs px-2 py-1">Edit</button>
                                <button wire:click="delete({{ $service->id }})" wire:confirm="Delete this service?" class="btn-ghost text-xs px-2 py-1 text-rose-600">Del</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="table-td text-center text-slate-400 py-8">No services yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit service' : 'Add service' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Name *</label>
                            <input type="text" wire:model="name" class="input">
                            @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Price *</label>
                            <input type="number" step="0.01" wire:model="price" class="input">
                            @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Category</label>
                            <select wire:model="category" class="input">
                                @foreach (\App\Models\Service::categories() as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
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
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save service</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
