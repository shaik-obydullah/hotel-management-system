<?php

use App\Models\HotelInfo;

if (! function_exists('money')) {
    function money(float|string|int|null $amount, ?string $currency = null): string
    {
        $currency ??= HotelInfo::current()->currency ?? 'USD';

        return $currency.' '.number_format((float) $amount, 2);
    }
}

if (! function_exists('booking_number')) {
    function booking_number(): string
    {
        return 'GAZ-'.now()->format('Ymd').'-'.strtoupper(random_int(1000, 9999));
    }
}
