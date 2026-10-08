<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\HotelInfo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBookingController extends Controller
{
    public function show(Request $request, string $bookingNumber): View
    {
        $booking = Booking::query()
            ->with(['guest', 'room.roomType', 'bookingServices.service', 'invoice'])
            ->where('booking_number', $bookingNumber)
            ->firstOrFail();

        return view('public.booking-detail', [
            'hotel' => HotelInfo::current(),
            'booking' => $booking,
        ]);
    }
}
