<?php

namespace App\Livewire\Admin;

use App\Models\Staff as StaffModel;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Staff')]
class Staff extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $role = '';
    public string $department = '';
    public string $phone = '';
    public string $status = 'active';

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'role', 'department', 'phone']);
        $this->status = 'active';
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $staff = StaffModel::findOrFail($id);
        $this->editingId = $staff->id;
        $this->name = $staff->name;
        $this->role = $staff->role ?? '';
        $this->department = $staff->department ?? '';
        $this->phone = $staff->phone ?? '';
        $this->status = $staff->status;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:60'],
            'department' => ['nullable', 'string', 'max:60'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        StaffModel::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'employee_id' => 'EMP-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT),
                'role' => $this->role ?: null,
                'department' => $this->department ?: null,
                'phone' => $this->phone ?: null,
                'status' => $this->status,
            ],
        );

        $this->showModal = false;
        session()->flash('message', $this->editingId ? 'Staff member updated.' : 'Staff member added.');
    }

    public function delete(int $id): void
    {
        StaffModel::findOrFail($id)->delete();
        session()->flash('message', 'Staff member removed.');
    }

    #[Computed]
    public function staffList()
    {
        return StaffModel::query()->with('user')->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.staff');
    }
}
