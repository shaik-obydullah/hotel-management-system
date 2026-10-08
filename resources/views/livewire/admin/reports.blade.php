<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Reports</h1>
            <p class="text-slate-500 text-sm mt-1">Occupancy, revenue and booking analytics</p>
        </div>
        <div class="flex items-center gap-2">
            <input type="month" wire:model.live="month" class="input w-auto">
            <input type="number" wire:model.live="year" min="2020" max="2035" class="input w-24">
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3 mt-6">
        <div class="card p-5">
            <div class="text-sm text-slate-500">Avg occupancy ({{ \Carbon\Carbon::parse($month.'-01')->format('M Y') }})</div>
            <div class="text-3xl font-bold mt-1">{{ $this->avgOccupancy }}%</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500">Best day ({{ \Carbon\Carbon::parse($month.'-01')->format('M Y') }})</div>
            @php $best = collect($this->occupancy)->sortByDesc('rate')->first(); @endphp
            <div class="text-3xl font-bold mt-1">{{ $best['rate'] ?? 0 }}%</div>
            <div class="text-xs text-slate-500">{{ $best['date'] ?? '—' }}</div>
        </div>
        <div class="card p-5">
            <div class="text-sm text-slate-500">Revenue {{ $this->year }}</div>
            <div class="text-3xl font-bold text-emerald-600 mt-1">{{ money($this->revenue->sum('revenue')) }}</div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2 mt-6">
        <div class="card p-6">
            <h2 class="font-bold mb-5">Daily occupancy — {{ \Carbon\Carbon::parse($month.'-01')->format('F Y') }}</h2>
            <div class="flex items-end gap-[3px] h-40">
                @foreach ($this->occupancy as $day)
                    <div class="flex-1 group relative" title="{{ $day['date'] }}: {{ $day['rate'] }}% ({{ $day['occupied'] }} rooms)">
                        <div class="rounded-t bg-indigo-500 hover:bg-indigo-600 transition-all" style="height: {{ max(2, $day['rate']) / 100 * 160 }}px"></div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex justify-between text-[10px] text-slate-400">
                <span>1</span><span>{{ (int) \Carbon\Carbon::parse($month.'-01')->endOfMonth()->format('d') / 4 }}</span><span>{{ (int) \Carbon\Carbon::parse($month.'-01')->endOfMonth()->format('d') / 2 }}</span><span>{{ (int) (\Carbon\Carbon::parse($month.'-01')->endOfMonth()->format('d') / 4) * 3 }}</span><span>{{ \Carbon\Carbon::parse($month.'-01')->endOfMonth()->format('d') }}</span>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold mb-5">Monthly revenue — {{ $this->year }}</h2>
            <div class="flex items-end gap-2 h-40">
                @foreach ($this->revenue as $monthData)
                    <div class="flex-1 flex flex-col items-center justify-end gap-1 group relative">
                        <span class="text-[9px] text-slate-500 opacity-0 group-hover:opacity-100">{{ money($monthData['revenue']) }}</span>
                        <div class="w-full rounded-t bg-emerald-500 hover:bg-emerald-600 transition-all" style="height: {{ max(2, $monthData['revenue'] / $this->maxRevenue * 120) }}px"></div>
                        <span class="text-[10px] text-slate-400">{{ $monthData['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2 mt-6">
        <div class="card p-6">
            <h2 class="font-bold mb-4">Bookings by status</h2>
            <div class="space-y-3">
                @foreach ($this->statusBreakdown as $row)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium">{{ $row['status']->label() }}</span>
                            <span class="text-slate-500">{{ $row['count'] }} · {{ $row['total'] > 0 ? round($row['count'] / $row['total'] * 100) : 0 }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full {{ $row['status']->color() }} transition-all" style="width: {{ $row['total'] > 0 ? $row['count'] / $row['total'] * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card p-6">
            <h2 class="font-bold mb-4">Bookings by source</h2>
            <div class="space-y-3">
                @foreach ($this->sourceBreakdown as $row)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium">{{ $row['source']->label() }}</span>
                            <span class="text-slate-500">{{ $row['count'] }} · {{ $row['total'] > 0 ? round($row['count'] / $row['total'] * 100) : 0 }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-teal-500 transition-all" style="width: {{ $row['total'] > 0 ? $row['count'] / $row['total'] * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
