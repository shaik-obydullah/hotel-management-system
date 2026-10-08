<?php

namespace App\Livewire\Admin;

use App\Models\Invoice;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Invoices & Payments')]
class Invoices extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function invoices()
    {
        return Invoice::query()
            ->with(['booking.guest', 'booking.room'])
            ->when($this->search, function ($q) {
                $q->where('invoice_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('booking', fn ($b) => $b->where('booking_number', 'like', '%'.$this->search.'%')
                        ->orWhereHas('guest', fn ($g) => $g->where('name', 'like', '%'.$this->search.'%')));
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);
    }

    #[Computed]
    public function totals(): array
    {
        return [
            'outstanding' => (float) Invoice::query()
                ->whereIn('status', ['unpaid', 'partially-paid'])
                ->get()
                ->sum(fn ($i) => $i->balance()),
            'collected' => (float) \App\Models\Payment::query()->where('status', 'completed')->sum('amount'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.invoices');
    }
}
