<?php

namespace App\Http\Controllers;

use App\Models\HotelInfo;
use App\Models\RoomType;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function welcome(): View
    {
        return view('public.welcome', [
            'hotel' => HotelInfo::current(),
            'roomTypes' => RoomType::query()->where('status', 'active')->withCount('rooms')->get(),
        ]);
    }

    public function rooms(): View
    {
        return view('public.rooms', [
            'hotel' => HotelInfo::current(),
            'roomTypes' => RoomType::query()
                ->where('status', 'active')
                ->withCount('rooms')
                ->get(),
        ]);
    }

    public function contact(): View
    {
        return view('public.contact', [
            'hotel' => HotelInfo::current(),
        ]);
    }
}
