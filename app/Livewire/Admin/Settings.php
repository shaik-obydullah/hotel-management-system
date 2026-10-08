<?php

namespace App\Livewire\Admin;

use App\Models\HotelInfo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Settings')]
class Settings extends Component
{
    public string $name = '';
    public string $tagline = '';
    public string $address = '';
    public string $city = '';
    public string $country = '';
    public string $phone = '';
    public string $email = '';
    public string $check_in_time = '';
    public string $check_out_time = '';
    public string $currency = 'USD';
    public string $tax_rate = '10';
    public string $description = '';

    public function mount(): void
    {
        $hotel = HotelInfo::current();
        $this->name = $hotel->name;
        $this->tagline = $hotel->tagline ?? '';
        $this->address = $hotel->address ?? '';
        $this->city = $hotel->city ?? '';
        $this->country = $hotel->country ?? '';
        $this->phone = $hotel->phone ?? '';
        $this->email = $hotel->email ?? '';
        $this->check_in_time = $hotel->check_in_time ?? '14:00';
        $this->check_out_time = $hotel->check_out_time ?? '11:00';
        $this->currency = $hotel->currency ?? 'USD';
        $this->tax_rate = (string) ($hotel->tax_rate ?? 10);
        $this->description = $hotel->description ?? '';
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:80'],
            'country' => ['nullable', 'string', 'max:80'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'check_in_time' => ['required'],
            'check_out_time' => ['required'],
            'currency' => ['required', 'string', 'max:10'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $hotel = HotelInfo::current();
        $hotel->fill([
            'name' => $this->name,
            'tagline' => $this->tagline ?: null,
            'address' => $this->address ?: null,
            'city' => $this->city ?: null,
            'country' => $this->country ?: null,
            'phone' => $this->phone ?: null,
            'email' => $this->email ?: null,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'currency' => $this->currency,
            'tax_rate' => $this->tax_rate,
            'description' => $this->description ?: null,
        ])->save();

        session()->flash('message', 'Hotel settings saved.');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
