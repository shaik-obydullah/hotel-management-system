@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">
        <div class="card overflow-hidden">
            <div class="bg-emerald-600 px-6 py-6 text-white flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold">Booking received!</h1>
                    <p class="text-emerald-100 text-sm">Your reservation has been confirmed. A confirmation was sent to {{ $booking->guest->email ?? 'your email' }}.</p>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wide">Booking number</div>
                        <div class="text-xl font-bold text-indigo-600">{{ $booking->booking_number }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-500 uppercase tracking-wide">Status</div>
                        <span class="badge {{ $booking->status->color() }} mt-1">{{ $booking->status->label() }}</span>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6 py-6">
                    <div>
                        <h3 class="font-semibold text-slate-500 text-sm uppercase tracking-wide mb-3">Guest</h3>
                        <div class="text-lg font-semibold">{{ $booking->guest->name }}</div>
                        <div class="text-sm text-slate-500">{{ $booking->guest->email }}</div>
                        <div class="text-sm text-slate-500">{{ $booking->guest->phone }}</div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-500 text-sm uppercase tracking-wide mb-3">Room</h3>
                        <div class="text-lg font-semibold">{{ $booking->room->room_number }} · {{ $booking->room->roomType->name }}</div>
                        <div class="text-sm text-slate-500">{{ $booking->adults }} adult(s){{ $booking->children ? ', '.$booking->children.' child(ren)' : '' }}</div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-5 grid sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wide">Check-in</div>
                        <div class="font-semibold">{{ $booking->check_in_date->format('D, M d, Y') }}</div>
                        <div class="text-xs text-slate-500">from {{ \Carbon\Carbon::parse($hotel->check_in_time)->format('g:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wide">Check-out</div>
                        <div class="font-semibold">{{ $booking->check_out_date->format('D, M d, Y') }}</div>
                        <div class="text-xs text-slate-500">by {{ \Carbon\Carbon::parse($hotel->check_out_time)->format('g:i A') }}</div>
                    </div>
                </div>

                <div class="mt-6 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">{{ $booking->nights }} night(s) × {{ money($booking->room_rate) }}</span>
                        <span class="font-medium">{{ money($booking->subtotal) }}</span>
                    </div>
                    @if ((float) $booking->discount > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Discount</span>
                            <span>-{{ money($booking->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-slate-600">Tax</span>
                        <span class="font-medium">{{ money($booking->tax) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold">
                        <span>Total</span>
                        <span>{{ money($booking->total_amount) }}</span>
                    </div>
                </div>

                @if ($booking->special_requests)
                    <div class="mt-6 rounded-lg bg-amber-50 border border-amber-200 p-4 text-sm text-amber-800">
                        <strong>Special requests:</strong> {{ $booking->special_requests }}
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}" class="btn-secondary">Back to home</a>
                    <a href="{{ route('booking.lookup') }}" class="btn-ghost">Look up another booking</a>
                </div>
            </div>
        </div>
    </div>
@endsection
