@props([
    'nav' => [],
    'logo' => null,
])

<div class="flex h-full flex-col overflow-y-auto px-4 py-6">
    {{-- Brand --}}
    <div class="flex h-10 shrink-0 items-center px-2">
        @if ($logo)
            <img src="{{ asset($logo) }}" alt="{{ brand('logo_text') }}" class="h-8 w-auto">
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
                @if ($active) aria-current="page" @endif
                class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm transition {{ $active ? 'bg-brand-50 font-semibold text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
