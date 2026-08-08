<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'email', 'phone', 'nationality', 'id_type', 'id_number',
    'address', 'city', 'country', 'vip_status', 'loyalty_points', 'notes',
])]
class Guest extends Model
{
    protected function casts(): array
    {
        return [
            'vip_status' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(GuestPreference::class);
    }
}
