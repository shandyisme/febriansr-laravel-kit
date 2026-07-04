@props([
    'name' => 'modal',
    'title' => null,
    'maxWidth' => 'lg',
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    $maxWidthClass = $maxWidths[$maxWidth] ?? $maxWidths['lg'];
@endphp

<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60"
        @click="open = false"
    ></div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        {{ $attributes->merge(['class' => 'relative w-full '.$maxWidthClass.' rounded-2xl bg-white p-6 shadow-xl']) }}
    >
        {{-- Close button --}}
        <button
            type="button"
            @click="open = false"
            class="absolute right-4 top-4 rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
            aria-label="Tutup"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        @if ($title)
            <h3 class="pr-8 text-base font-semibold text-slate-900">{{ $title }}</h3>
        @endif

        <div class="{{ $title ? 'mt-4' : '' }} text-sm text-slate-600">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="mt-6 flex justify-end gap-2">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
