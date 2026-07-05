@props([
    'name' => 'slideover',
    'title' => null,
    'subtitle' => null,
    'width' => 'max-w-lg',
])

{{-- Open anywhere with: $dispatch('open-slide-over', '{{ $name }}') --}}
<div x-data="{ open: false }"
    x-on:open-slide-over.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:keydown.escape.window="open = false"
    x-show="open" x-cloak class="fixed inset-0 z-50" role="dialog" aria-modal="true">

    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="open = false"></div>

    <div x-show="open"
        x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 flex w-full {{ $width }} flex-col bg-white/95 shadow-2xl backdrop-blur-xl">
        <header class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-5">
            <div>
                <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                @if ($subtitle)<p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>@endif
            </div>
            <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </header>
        <div class="flex-1 overflow-y-auto px-6 py-5">{{ $slot }}</div>
        @isset($footer)
            <footer class="flex justify-end gap-2 border-t border-slate-200 px-6 py-4">{{ $footer }}</footer>
        @endisset
    </div>
</div>
