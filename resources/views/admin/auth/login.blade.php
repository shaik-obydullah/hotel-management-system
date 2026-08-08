<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Login · {{ \App\Models\HotelInfo::current()->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-2xl mx-auto mb-3">H</div>
            <h1 class="text-2xl font-bold text-slate-900">{{ \App\Models\HotelInfo::current()->name }}</h1>
            <p class="text-sm text-slate-500">Staff &amp; Admin Portal</p>
        </div>

        <div class="card p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 p-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="input">
                </div>
                <div>
                    <label class="label">Password</label>
                    <input type="password" name="password" required autocomplete="current-password" class="input">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        Remember me
                    </label>
                    <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:underline">← Back to site</a>
                </div>
                <button type="submit" class="btn-primary w-full">Sign in</button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">Admin: admin@example.com &nbsp;·&nbsp; Password: password</p>
    </div>
    @livewireScripts
</body>
</html>
