<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Staff</h1>
            <p class="text-slate-500 text-sm mt-1">Team directory</p>
        </div>
        <button wire:click="openCreate" class="btn-primary">+ Add staff</button>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="table-wrap">
            <thead>
                <tr>
                    <th class="table-th">Name</th>
                    <th class="table-th">Employee ID</th>
                    <th class="table-th">Role</th>
                    <th class="table-th">Department</th>
                    <th class="table-th">Phone</th>
                    <th class="table-th">Status</th>
                    <th class="table-th text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->staffList as $staff)
                    <tr class="hover:bg-slate-50">
                        <td class="table-td font-semibold">{{ $staff->name }}</td>
                        <td class="table-td text-slate-500">{{ $staff->employee_id }}</td>
                        <td class="table-td">{{ $staff->role ?? '—' }}</td>
                        <td class="table-td"><span class="badge bg-slate-100 text-slate-700">{{ $staff->department ?? '—' }}</span></td>
                        <td class="table-td">{{ $staff->phone ?? '—' }}</td>
                        <td class="table-td">
                            <span class="badge {{ $staff->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">{{ $staff->status }}</span>
                        </td>
                        <td class="table-td">
                            <div class="flex justify-end gap-2">
                                <button wire:click="openEdit({{ $staff->id }})" class="btn-ghost text-xs px-2 py-1">Edit</button>
                                <button wire:click="delete({{ $staff->id }})" wire:confirm="Remove this staff member?" class="btn-ghost text-xs px-2 py-1 text-rose-600">Del</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="table-td text-center text-slate-400 py-8">No staff members yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">{{ $editingId ? 'Edit staff member' : 'Add staff member' }}</h2>
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
                            <label class="label">Phone</label>
                            <input type="text" wire:model="phone" class="input">
                        </div>
                        <div>
                            <label class="label">Role</label>
                            <input type="text" wire:model="role" class="input" placeholder="Housekeeper">
                        </div>
                        <div>
                            <label class="label">Department</label>
                            <select wire:model="department" class="input">
                                <option value="">Select…</option>
                                @foreach (['Front Office', 'Housekeeping', 'Maintenance', 'Restaurant', 'Spa', 'Management'] as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
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
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save staff</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
