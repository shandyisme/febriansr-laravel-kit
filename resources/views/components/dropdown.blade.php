@props([
    'align' => 'right',
    'width' => 'w-48',
])

<div class="relative" x-data="{ open: false }">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-cloak
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $align === 'right' ? 'right-0' : 'left-0' }} {{ $width }} rounded-xl bg-white p-1 shadow-lg ring-1 ring-slate-900/5"
    >
        {{ $slot }}
    </div>
</div>
