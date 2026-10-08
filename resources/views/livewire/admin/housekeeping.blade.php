<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Housekeeping</h1>
            <p class="text-slate-500 text-sm mt-1">Cleaning tasks &amp; maintenance</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="$set('showMaintenanceModal', true)" class="btn-secondary">+ Maintenance</button>
            <button wire:click="$set('showTaskModal', true)" class="btn-primary">+ Task</button>
        </div>
    </div>

    <div class="mt-6">
        <div class="flex gap-1 border-b border-slate-200">
            <button wire:click="$set('tab', 'tasks')" class="px-4 py-2 text-sm font-semibold {{ $tab === 'tasks' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }}">Cleaning tasks</button>
            <button wire:click="$set('tab', 'maintenance')" class="px-4 py-2 text-sm font-semibold {{ $tab === 'maintenance' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }}">Maintenance requests</button>
        </div>
    </div>

    @if ($tab === 'tasks')
        <div class="card mt-4 overflow-x-auto">
            <table class="table-wrap">
                <thead>
                    <tr>
                        <th class="table-th">Room</th>
                        <th class="table-th">Type</th>
                        <th class="table-th">Priority</th>
                        <th class="table-th">Status</th>
                        <th class="table-th">Assigned to</th>
                        <th class="table-th">Scheduled</th>
                        <th class="table-th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->tasks as $task)
                        <tr class="hover:bg-slate-50">
                            <td class="table-td font-semibold">Room {{ $task->room->room_number }}</td>
                            <td class="table-td">{{ \Illuminate\Support\Str::title($task->task_type) }}</td>
                            <td class="table-td">
                                <span class="badge {{ $task->priority === 'high' ? 'bg-rose-100 text-rose-700' : ($task->priority === 'medium' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">{{ $task->priority }}</span>
                            </td>
                            <td class="table-td">
                                <span class="badge {{ $task->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($task->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">{{ \Illuminate\Support\Str::title($task->status) }}</span>
                            </td>
                            <td class="table-td">{{ $task->assignee?->name ?? '—' }}</td>
                            <td class="table-td">{{ $task->scheduled_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="table-td">
                                <div class="flex justify-end gap-2">
                                    @if ($task->status !== 'completed')
                                        <button wire:click="completeTask({{ $task->id }})" class="text-xs text-emerald-600 hover:underline">Complete</button>
                                    @endif
                                    <button wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete task?" class="text-xs text-rose-600 hover:underline">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="table-td text-center text-slate-400 py-8">No cleaning tasks.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100">{{ $this->tasks->links() }}</div>
        </div>
    @else
        <div class="card mt-4 overflow-x-auto">
            <table class="table-wrap">
                <thead>
                    <tr>
                        <th class="table-th">Room</th>
                        <th class="table-th">Issue</th>
                        <th class="table-th">Priority</th>
                        <th class="table-th">Status</th>
                        <th class="table-th">Reported</th>
                        <th class="table-th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->maintenanceRequests as $request)
                        <tr class="hover:bg-slate-50">
                            <td class="table-td font-semibold">Room {{ $request->room->room_number }}</td>
                            <td class="table-td">
                                <div class="font-medium">{{ $request->title }}</div>
                                <div class="text-xs text-slate-500">{{ $request->description }}</div>
                            </td>
                            <td class="table-td">
                                <span class="badge {{ $request->priority === 'high' ? 'bg-rose-100 text-rose-700' : ($request->priority === 'medium' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600') }}">{{ $request->priority }}</span>
                            </td>
                            <td class="table-td">
                                <select wire:change="updateMaintenanceStatus({{ $request->id }}, $event.target.value)" class="text-xs rounded-lg border-slate-300 py-1">
                                    @foreach (['open', 'in-progress', 'resolved'] as $s)
                                        <option value="{{ $s }}" {{ $request->status === $s ? 'selected' : '' }}>{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $s)) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="table-td text-xs">{{ $request->reporter?->name }} · {{ $request->created_at->format('M d, Y') }}</td>
                            <td class="table-td text-right">
                                @if ($request->status === 'resolved' && $request->resolved_at)
                                    <span class="text-xs text-slate-400">{{ $request->resolved_at->format('M d, Y') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="table-td text-center text-slate-400 py-8">No maintenance requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100">{{ $this->maintenanceRequests->links() }}</div>
        </div>
    @endif

    {{-- Task modal --}}
    @if ($showTaskModal)
        <div class="modal-backdrop" wire:click.self="$set('showTaskModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">New cleaning task</h2>
                    <button wire:click="$set('showTaskModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="createTask" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Room *</label>
                            <select wire:model="task_room_id" class="input">
                                <option value="">Select room…</option>
                                @foreach ($this->rooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->room_number }} ({{ $room->roomType->name }})</option>
                                @endforeach
                            </select>
                            @error('task_room_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Task type *</label>
                            <select wire:model="task_type" class="input">
                                <option value="cleaning">Cleaning</option>
                                <option value="inspection">Inspection</option>
                                <option value="minibar-restock">Minibar restock</option>
                                <option value="linen-change">Linen change</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Priority</label>
                            <select wire:model="task_priority" class="input">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Status</label>
                            <select wire:model="task_status" class="input">
                                <option value="pending">Pending</option>
                                <option value="in-progress">In progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Assign to</label>
                            <select wire:model="task_assignee" class="input">
                                <option value="">Unassigned</option>
                                @foreach ($this->staffUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">Scheduled date</label>
                            <input type="date" wire:model="task_date" class="input">
                        </div>
                        <div class="col-span-2">
                            <label class="label">Notes</label>
                            <textarea wire:model="task_notes" rows="2" class="input"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showTaskModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Create task</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Maintenance modal --}}
    @if ($showMaintenanceModal)
        <div class="modal-backdrop" wire:click.self="$set('showMaintenanceModal', false)">
            <div class="modal-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold">New maintenance request</h2>
                    <button wire:click="$set('showMaintenanceModal', false)" class="text-slate-400 hover:text-slate-600 text-xl">×</button>
                </div>
                <form wire:submit="createMaintenance" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Room *</label>
                            <select wire:model="maint_room_id" class="input">
                                <option value="">Select room…</option>
                                @foreach ($this->rooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->room_number }}</option>
                                @endforeach
                            </select>
                            @error('maint_room_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="label">Priority</label>
                            <select wire:model="maint_priority" class="input">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="label">Issue title *</label>
                            <input type="text" wire:model="maint_title" class="input" placeholder="AC not cooling">
                            @error('maint_title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="label">Description</label>
                            <textarea wire:model="maint_description" rows="3" class="input"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="$set('showMaintenanceModal', false)" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Create request</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
