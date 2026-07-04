@props([
    'nav' => [],
    'logo' => null,
    'collapsible' => false,
])

<div class="flex h-full flex-col overflow-y-auto px-3 py-6">
    {{-- Brand --}}
    <div class="flex h-10 shrink-0 items-center px-2" @if ($collapsible) :class="collapsed ? 'justify-center px-0' : ''" @endif>
        @if ($logo)
            <img src="{{ asset($logo) }}" alt="{{ brand('logo_text') }}" class="h-8 w-auto">
        @elseif ($collapsible)
            <span x-show="!collapsed" class="text-lg font-bold text-brand-600">{{ brand('logo_text') }}</span>
            <span x-show="collapsed" x-cloak class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-sm font-bold text-white">{{ mb_substr(brand('logo_text'), 0, 1) }}</span>
        @else
            <span class="text-lg font-bold text-brand-600">{{ brand('logo_text') }}</span>
        @endif
    </div>

    {{-- Navigation --}}
    <nav class="mt-6 flex flex-1 flex-col gap-1">
        @foreach ($nav as $item)
            @php $active = request()->routeIs($item['route'].'*'); @endphp
            <a
                href="{{ route($item['route']) }}"
                title="{{ $item['label'] }}"
                @if ($active) aria-current="page" @endif
                @if ($collapsible) :class="collapsed ? 'justify-center' : ''" @endif
                class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm transition {{ $active ? 'bg-gradient-to-r from-brand-500 to-brand-600 font-semibold text-white shadow-sm shadow-brand-600/25' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900' }}"
            >
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span @if ($collapsible) x-show="!collapsed" @endif>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
