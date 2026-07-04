@props([
    'label',
    'value',
    'icon' => null,
    'trend' => null,
    'trendUp' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5']) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-xs font-medium text-slate-500">{{ $label }}</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $value }}</p>
        </div>

        @if ($icon)
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                {!! $icon !!}
            </div>
        @endif
    </div>

    @if ($trend !== null)
        <div class="mt-3 flex items-center gap-2 text-xs">
            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 font-medium {{ $trendUp ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                @if ($trendUp)
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75 12 8.25l7.5 7.5" />
                    </svg>
                @else
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75l-7.5-7.5" />
                    </svg>
                @endif
                {{ $trend }}
            </span>
            <span class="text-slate-400">vs bulan lalu</span>
        </div>
    @endif
</div>
