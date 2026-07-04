@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5']) }}>
    @if ($title || $subtitle || isset($actions))
        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-4">
            <div>
                @if ($title)
                    <h3 class="text-sm font-semibold text-slate-900">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex shrink-0 items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
