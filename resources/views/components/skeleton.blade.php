@props([
    'lines' => 3,
    'avatar' => false,
])

@php $widths = ['w-11/12', 'w-4/5', 'w-3/5', 'w-2/3', 'w-1/2']; @endphp

<div {{ $attributes->merge(['class' => 'animate-pulse']) }}>
    @if ($avatar)
        <div class="mb-4 flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-slate-200"></div>
            <div class="flex-1 space-y-2">
                <div class="h-3 w-1/3 rounded bg-slate-200"></div>
                <div class="h-3 w-1/2 rounded bg-slate-200"></div>
            </div>
        </div>
    @endif

    <div class="space-y-2.5">
        @for ($i = 0; $i < (int) $lines; $i++)
            <div class="h-3 rounded bg-slate-200 {{ $widths[$i % count($widths)] }}"></div>
        @endfor
    </div>
</div>
