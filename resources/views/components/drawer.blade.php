@props([
    'name' => 'drawer',
    'title' => null,
    'side' => 'right',      // right | left
    'width' => 'max-w-md',
])

{{-- Open anywhere with: $dispatch('open-drawer', '{{ $name }}') --}}
<div x-data="{ open: false }"
    x-on:open-drawer.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:keydown.escape.window="open = false"
    x-show="open" x-cloak class="fixed inset-0 z-50" role="dialog" aria-modal="true">

    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/50" @click="open = false"></div>

    <div x-show="open"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="{{ $side === 'left' ? '-translate-x-full' : 'translate-x-full' }}"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $side === 'left' ? '-translate-x-full' : 'translate-x-full' }}"
        class="fixed inset-y-0 {{ $side === 'left' ? 'left-0' : 'right-0' }} flex w-full {{ $width }} flex-col bg-white shadow-xl">
        <header class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <h3 class="text-sm font-semibold text-slate-900">{{ $title }}</h3>
            <button type="button" @click="open = false" class="text-slate-400 hover:text-slate-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </header>
        <div class="flex-1 overflow-y-auto p-5">{{ $slot }}</div>
        @isset($footer)
            <footer class="border-t border-slate-200 px-5 py-4">{{ $footer }}</footer>
        @endisset
    </div>
</div>
