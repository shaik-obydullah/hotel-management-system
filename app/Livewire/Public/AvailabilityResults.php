<?php

namespace App\Livewire\Public;

use App\Models\RoomType;
use App\Services\RoomService;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Check Availability')]
class AvailabilityResults extends Component
{
    #[Url]
    public ?string $check_in = null;

    #[Url]
    public ?string $check_out = null;

    #[Url(as: 'adults')]
    public int $adults = 2;

    #[Url]
    public int $children = 0;

    #[Url(as: 'room_type')]
    public ?string $room_type = null;

    public bool $searched = false;

    public ?string $error = null;

    public function mount(): void
    {
        if (! $this->check_in) {
            $this->check_in = CarbonImmutable::today()->addDay()->toDateString();
        }
        if (! $this->check_out) {
            $this->check_out = CarbonImmutable::today()->addDays(3)->toDateString();
        }
        $this->searched = request()->filled('check_in');
    }

    public function search(): void
    {
        $this->validate();

        if (CarbonImmutable::parse($this->check_out)->lte(CarbonImmutable::parse($this->check_in))) {
            $this->error = 'Check-out date must be after the check-in date.';
            $this->searched = false;

            return;
        }

        $this->error = null;
        $this->searched = true;
    }

    public function rules(): array
    {
        return [
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date'],
            'adults' => ['required', 'integer', 'min:1', 'max:10'],
            'children' => ['required', 'integer', 'min:0', 'max:10'],
        ];
    }

    #[Computed]
    public function summary()
    {
        return app(RoomService::class)->availabilitySummary($this->check_in, $this->check_out);
    }

    #[Computed]
    public function roomTypes()
    {
        return RoomType::query()->where('status', 'active')->orderBy('base_price')->get();
    }

    public function render()
    {
        return view('livewire.public.availability-results');
    }
}
