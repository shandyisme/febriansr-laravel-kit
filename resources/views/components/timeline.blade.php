@props([
    'items' => [],   // [['title'=>, 'time'=>, 'description'=>, 'color'=>'brand'|'green'|...], ...]
])

@php
    $dot = ['brand' => 'bg-brand-500', 'green' => 'bg-green-500', 'red' => 'bg-red-500', 'amber' => 'bg-amber-500', 'accent' => 'bg-accent-500'];
@endphp

<ol {{ $attributes->merge(['class' => 'relative ml-2 border-l border-slate-200']) }}>
    @foreach ($items as $item)
        <li class="mb-6 pl-6 last:mb-0">
            <span class="absolute -left-[7px] mt-1 h-3.5 w-3.5 rounded-full ring-4 ring-white {{ $dot[$item['color'] ?? 'brand'] ?? 'bg-brand-500' }}"></span>
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <p class="text-sm font-medium text-slate-900">{{ $item['title'] ?? '' }}</p>
                @if (! empty($item['time']))<span class="text-xs text-slate-400">{{ $item['time'] }}</span>@endif
            </div>
            @if (! empty($item['description']))
                <p class="mt-1 text-sm text-slate-500">{{ $item['description'] }}</p>
            @endif
        </li>
    @endforeach
</ol>
