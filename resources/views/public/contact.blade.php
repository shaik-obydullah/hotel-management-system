@extends('layouts.app')

@section('content')
    <section class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-16">
            <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-2">Get in touch</p>
            <h1 class="text-3xl lg:text-4xl font-extrabold">Contact Us</h1>
            <p class="mt-2 text-slate-300">We would love to hear from you.</p>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">

        <div class="grid gap-8 md:grid-cols-2 mt-2">
            <div class="card p-6 space-y-4">
                <div>
                    <div class="text-sm font-semibold text-slate-500">Address</div>
                    <div class="mt-1">{{ $hotel->address ?? '—' }}</div>
                    <div>{{ $hotel->city ?? '' }}{{ $hotel->city && $hotel->country ? ', ' : '' }}{{ $hotel->country ?? '' }}</div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-500">Phone</div>
                    <div class="mt-1">{{ $hotel->phone ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-500">Email</div>
                    <div class="mt-1">{{ $hotel->email ?? '—' }}</div>
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-500">Check-in / Check-out</div>
                    <div class="mt-1">Check-in from {{ \Carbon\Carbon::parse($hotel->check_in_time ?? '14:00')->format('g:i A') }}</div>
                    <div>Check-out by {{ \Carbon\Carbon::parse($hotel->check_out_time ?? '11:00')->format('g:i A') }}</div>
                </div>
            </div>

            <div class="card p-6">
                <h2 class="font-bold mb-4">Send us a message</h2>
                <form class="space-y-4" onsubmit="event.preventDefault(); this.querySelector('button').textContent = 'Message sent — we will reply soon!';">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Name</label>
                            <input type="text" class="input" required>
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" class="input" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Subject</label>
                        <input type="text" class="input" required>
                    </div>
                    <div>
                        <label class="label">Message</label>
                        <textarea class="input" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Send message</button>
                </form>
            </div>
        </div>
    </div>
@endsection
