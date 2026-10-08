<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\BookingSource;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'booking_number', 'guest_id', 'room_id', 'check_in_date', 'check_out_date',
    'adults', 'children', 'status', 'source', 'special_requests', 'room_rate',
    'nights', 'subtotal', 'discount', 'tax', 'total_amount', 'paid_amount', 'created_by',
])]
class Booking extends Model
{
    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'room_rate' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'status' => BookingStatus::class,
            'source' => BookingSource::class,
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookingServices(): HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(BookingStatusHistory::class)->latest();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function servicesTotal(): float
    {
        return (float) $this->bookingServices()->sum('amount');
    }

    public function isActive(): bool
    {
        return in_array($this->status, [BookingStatus::Confirmed, BookingStatus::CheckedIn]);
    }
}
