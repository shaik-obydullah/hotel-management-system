# Grand Azure Hotel — Hotel Management System

![PHP](https://img.shields.io/badge/PHP-8.4-%23777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-%23FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4-%23fb70a9?style=flat-square&logo=livewire&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-%2338B2AC?style=flat-square&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-%23ffffff?style=flat-square&logo=alpine.js&color=%238BC0D0&logoColor=%2338BDF8)
![MySQL](https://img.shields.io/badge/MySQL-8.0-%234479A1?style=flat-square&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-%232496ED?style=flat-square&logo=docker&logoColor=white)
![PHPUnit](https://img.shields.io/badge/tests-PHPUnit-%23C0392B?style=flat-square&logo=php&logoColor=white)
![MIT](https://img.shields.io/badge/license-MIT-%23A31F34?style=flat-square)

A full hotel management system built with the **TALL stack** (Tailwind CSS 4, Alpine.js, Laravel 13, Livewire 4), running fully inside Docker. Includes a public website (room availability, online booking, booking lookup) and a role-protected admin panel (bookings, rooms, guests, billing, housekeeping, reports, staff, settings).

## Quick start

```bash
docker compose up -d
docker compose exec app php artisan migrate:fresh --seed --force
docker compose exec app npm run build
```

The app is then available at `http://localhost:8000`.

> The container image installs PHP, Composer and Node itself — no local PHP/Composer needed.

## Access & credentials

| Item | URL | Credentials |
|---|---|---|
| Public website | http://localhost:8000 | — |
| Admin panel | http://localhost:8000/admin/login | `admin@example.com` / `password` |
| Staff login | (same login page) | `staff@example.com` / `password` |
| phpMyAdmin | http://localhost:8044 (also 8045) | `hotel` / `hotel_secret` |
| MySQL | port 3306 (internal only) | db `hotel`, user `hotel`, pass `hotel_secret`, root `root_secret` |

## Public site features

- **Home / Rooms / Contact** — landing pages driven by `hotel_info` and `room_types`.
- **Availability** — pick dates, see per-room-type nightly rate and how many rooms are free (`/availability`).
- **Book online** — choose a room type and dates, enter guest details, price breaks down into subtotal + tax (`/booking`).
- **Find my booking** — look up a reservation by booking number + email (`/booking/lookup`).

Booking numbers look like `GAZ-YYYYMMDD-XXXX`.

## Admin panel features

- **Dashboard** — today's arrivals/departures, occupancy, monthly revenue, recent bookings.
- **Bookings** — list/filter, calendar view, create booking, and a detail page with check-in / check-out / cancel actions, status history, add services, and payments.
- **Rooms & room types** — manage rooms, assign floor/type, change room status; room types with base price, amenities and seasonal rates.
- **Guests** — directory with preferences and booking history.
- **Invoices** — invoice list, detail, record payments, and **PDF download** (generated with dompdf). Invoices are created automatically on check-out.
- **Housekeeping** — housekeeping tasks and maintenance requests.
- **Services** — service catalogue (Restaurant, Room Service, Spa, Laundry, Minibar, Other) used for add-on charges.
- **Reports** — daily occupancy chart, monthly revenue chart, bookings by status/source.
- **Staff** — team directory linked to login users.
- **Settings** — hotel branding, contact info, check-in/out times, currency and tax rate.

Admin routes are guarded by `auth` + `role:admin|staff` middleware (Spatie permissions). Admin can do everything; staff accounts share the same screens in this build.

## Seeded demo data

Running the seeder loads a realistic dataset so every page has content:

- 3 login users (admin, front desk, housekeeper) with roles
- Hotel info (Grand Azure Hotel, USD, 10% tax)
- 5 floors, 4 room types (Standard Single, Deluxe Double, Executive Suite, Presidential Suite), 25 rooms
- 40 guests (mix of nationalities, VIP flags, loyalty points, preferences)
- 42 bookings spanning the year: checked-out stays (with invoices + payments spread across months), current stays (checked-in), future confirmations, pending and cancelled — none with overlapping room conflicts
- 15 bookable services, 8 staff members, housekeeping tasks and maintenance requests

## Screenshots

All screenshots live in the `screenshots/` folder.

### Public website

| Screenshot | Page |
|---|---|
| `Website-Home.png` | Public home / landing page |
| `Website-Rooms.png` | Rooms & suites listing |
| `Check-Availability.png` | Availability search results |
| `Complete-Booking.png` | Online booking form |
| `Find-my-booking.png` | Booking lookup by booking number + email |
| `Contact-Us.png` | Contact page |

### Admin panel

| Screenshot | Page |
|---|---|
| `Staff-Dashboard.png` | Dashboard (arrivals, occupancy, revenue) |
| `Room-Management.png` | Rooms management & room status |
| `All-Booking.png` | Bookings list |
| `Booking-Calendar.png` | Booking calendar view |
| `New-Booking.png` | Create a new booking |
| `Guests.png` | Guest directory |
| `Invoices-and-Payments.png` | Invoices & payments |
| `Housekeeping.png` | Housekeeping tasks |
| `Assign-a-Task.png` | Assigning a housekeeping task |
| `Maintenance-Request.png` | Maintenance request modal |
| `Services-and-Menu.png` | Services catalogue |
| `Reports.png` | Reports & charts |
| `Staff-Management.png` | Staff management |
| `Hotel-Settings.png` | Hotel settings |

![Public home](screenshots/Website-Home.png)
![Rooms & suites](screenshots/Website-Rooms.png)
![Availability](screenshots/Check-Availability.png)
![Online booking](screenshots/Complete-Booking.png)
![Booking lookup](screenshots/Find-my-booking.png)
![Contact](screenshots/Contact-Us.png)
![Dashboard](screenshots/Staff-Dashboard.png)
![Room management](screenshots/Room-Management.png)
![Bookings list](screenshots/All-Booking.png)
![Booking calendar](screenshots/Booking-Calendar.png)
![New booking](screenshots/New-Booking.png)
![Guests](screenshots/Guests.png)
![Invoices & payments](screenshots/Invoices-and-Payments.png)
![Housekeeping](screenshots/Housekeeping.png)
![Assign a task](screenshots/Assign-a-Task.png)
![Maintenance request](screenshots/Maintenance-Request.png)
![Services & menu](screenshots/Services-and-Menu.png)
![Reports](screenshots/Reports.png)
![Staff management](screenshots/Staff-Management.png)
![Hotel settings](screenshots/Hotel-Settings.png)

## Tech stack

- **Backend:** PHP 8.4, Laravel 13, Livewire 4 (attribute-style components: `#[Layout]`, `#[Title]`, `#[Computed]`)
- **Frontend:** Tailwind CSS 4 (via `@tailwindcss/vite`), Alpine.js, Vite
- **Database:** MySQL 8.0 (compose service `db`), Eloquent ORM
- **Extras:** `spatie/laravel-permission` (roles), `barryvdh/laravel-dom-pdf` (invoice PDFs)
- **Infra:** Docker Compose with separate `app` (PHP-FPM), `web` (nginx), `db` (MySQL), `phpMyAdmin` containers; persistent data in the `hotel_db_data` volume

## Project structure (highlights)

```
app/
├── Enums/            # BookingStatus, RoomStatus, BookingSource, InvoiceStatus, PaymentMethod, PaymentStatus
├── Livewire/
│   ├── Admin/        # dashboard, bookings, rooms, guests, invoices, housekeeping, reports, staff, settings, services...
│   └── Public/       # AvailabilityResults, PublicBooking, BookingLookup
├── Models/           # Eloquent models for every table
├── Services/         # RoomService (availability), BookingService (pricing/check-in/out/cancel), BillingService, ReportService
└── Support/helpers.php  # money(), booking_number()
database/
├── migrations/       # 18 domain tables + Spatie permission tables
└── seeders/          # idempotent seeders producing realistic data
docker/
├── Dockerfile        # php:8.4-fpm + node + composer
├── nginx/default.conf
└── php/zz-app.conf   # FPM runs as appuser (uid 1000)
docker-compose.yml
```

## Useful commands

```bash
docker compose ps                 # status; containers hotel_app / hotel_web / hotel_db / hotel_phpmyadmin
docker compose logs -f app        # follow Laravel logs
docker compose exec app php artisan migrate:fresh --seed --force   # rebuild DB with demo data
docker compose exec app npm run build   # rebuild frontend assets
```

## Notes

- Containers use the `hotel_` prefix and are set to `restart: "no"` — start them explicitly with `docker compose up -d`.
- `phpMyAdmin` listens on both 8044 and 8045 (both mapped to port 80 of the phpMyAdmin container).
- `laravel.log` is written by the `appuser` FPM process; if the file was ever created by root (e.g. via `docker compose exec`), run `docker compose exec app chown -R appuser:appuser storage bootstrap/cache`.
