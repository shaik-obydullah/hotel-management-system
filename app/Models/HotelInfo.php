<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'tagline', 'address', 'city', 'country', 'phone', 'email',
    'check_in_time', 'check_out_time', 'currency', 'tax_rate', 'description',
])]
class HotelInfo extends Model
{
    protected $table = 'hotel_info';

    public static function current(): self
    {
        return static::query()->first() ?? new static([
            'name' => 'Hotel',
            'currency' => 'USD',
            'tax_rate' => 10,
            'check_in_time' => '14:00',
            'check_out_time' => '11:00',
        ]);
    }
}
