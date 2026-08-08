<?php

use App\Livewire\Admin\BookingCalendar;
use App\Livewire\Admin\BookingDetail;
use App\Livewire\Admin\Bookings;
use App\Livewire\Admin\CreateBooking;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Floors;
use App\Livewire\Admin\GuestDetail;
use App\Livewire\Admin\Guests;
use App\Livewire\Admin\Housekeeping;
use App\Livewire\Admin\InvoiceDetail;
use App\Livewire\Admin\Invoices;
use App\Livewire\Admin\Reports;
use App\Livewire\Admin\RoomTypes;
use App\Livewire\Admin\Rooms;
use App\Livewire\Admin\Services;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\Staff;
use App\Livewire\Public\AvailabilityResults;
use App\Livewire\Public\BookingLookup;
use App\Livewire\Public\PublicBooking;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicePdfController;
use App\Http\Controllers\PublicBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/availability', AvailabilityResults::class)->name('availability');
Route::get('/booking', PublicBooking::class)->name('booking');
Route::get('/booking/lookup', BookingLookup::class)->name('booking.lookup');
Route::get('/booking/{booking_number}', [PublicBookingController::class, 'show'])->name('booking.show');

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware(['auth', 'role:admin|staff'])->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/rooms', Rooms::class)->name('admin.rooms');
    Route::get('/room-types', RoomTypes::class)->name('admin.room-types');
    Route::get('/floors', Floors::class)->name('admin.floors');
    Route::get('/bookings', Bookings::class)->name('admin.bookings');
    Route::get('/bookings/create', CreateBooking::class)->name('admin.bookings.create');
    Route::get('/bookings/calendar', BookingCalendar::class)->name('admin.bookings.calendar');
    Route::get('/bookings/{booking}', BookingDetail::class)->name('admin.bookings.show');
    Route::get('/guests', Guests::class)->name('admin.guests');
    Route::get('/guests/{guest}', GuestDetail::class)->name('admin.guests.show');
    Route::get('/invoices', Invoices::class)->name('admin.invoices');
    Route::get('/invoices/{invoice}', InvoiceDetail::class)->name('admin.invoices.show');
    Route::get('/invoices/{invoice}/pdf', [InvoicePdfController::class, 'show'])->name('admin.invoices.pdf');
    Route::get('/housekeeping', Housekeeping::class)->name('admin.housekeeping');
    Route::get('/services', Services::class)->name('admin.services');
    Route::get('/reports', Reports::class)->name('admin.reports');
    Route::get('/staff', Staff::class)->name('admin.staff');
    Route::get('/settings', Settings::class)->name('admin.settings');
});
