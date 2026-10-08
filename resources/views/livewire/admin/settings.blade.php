<div>
    @if (session('message'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-700">{{ session('message') }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Hotel settings</h1>
            <p class="text-slate-500 text-sm mt-1">Branding, contact and operational defaults</p>
        </div>
    </div>

    <form wire:submit="save" class="grid gap-6 lg:grid-cols-3 mt-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h2 class="font-bold mb-4">Branding</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="label">Hotel name *</label>
                        <input type="text" wire:model="name" class="input">
                        @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Tagline</label>
                        <input type="text" wire:model="tagline" class="input">
                    </div>
                    <div class="col-span-2">
                        <label class="label">Short description</label>
                        <textarea wire:model="description" rows="3" class="input"></textarea>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h2 class="font-bold mb-4">Contact &amp; address</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="label">Address</label>
                        <input type="text" wire:model="address" class="input">
                    </div>
                    <div>
                        <label class="label">City</label>
                        <input type="text" wire:model="city" class="input">
                    </div>
                    <div>
                        <label class="label">Country</label>
                        <input type="text" wire:model="country" class="input">
                    </div>
                    <div>
                        <label class="label">Phone</label>
                        <input type="text" wire:model="phone" class="input">
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" wire:model="email" class="input">
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h2 class="font-bold mb-4">Operational defaults</h2>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div>
                        <label class="label">Check-in time</label>
                        <input type="time" wire:model="check_in_time" class="input">
                    </div>
                    <div>
                        <label class="label">Check-out time</label>
                        <input type="time" wire:model="check_out_time" class="input">
                    </div>
                    <div>
                        <label class="label">Currency</label>
                        <select wire:model="currency" class="input">
                            <option value="USD">USD $</option>
                            <option value="EUR">EUR €</option>
                            <option value="AED">AED</option>
                            <option value="GBP">GBP £</option>
                            <option value="INR">INR ₹</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Tax rate (%)</label>
                        <input type="number" step="0.01" min="0" max="100" wire:model="tax_rate" class="input">
                        @error('tax_rate') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Save settings</button>
            </div>
        </div>

        <div>
            <div class="card p-6">
                <h2 class="font-bold mb-3">Info</h2>
                <p class="text-sm text-slate-500 leading-relaxed">
                    These values drive the public website and invoices. Bookings use the
                    check-in/check-out times for day-counting, and the tax rate is applied
                    to the taxable portion of generated invoices.
                </p>
            </div>
        </div>
    </form>
</div>
