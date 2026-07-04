@props([
    'variant' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $variants = [
        'success' => [
            'wrap' => 'bg-green-50 ring-green-600/10 text-green-800',
            'icon' => 'text-green-600',
            'title' => 'text-green-900',
            'close' => 'text-green-600 hover:bg-green-100',
        ],
        'error' => [
            'wrap' => 'bg-red-50 ring-red-600/10 text-red-800',
            'icon' => 'text-red-600',
            'title' => 'text-red-900',
            'close' => 'text-red-600 hover:bg-red-100',
        ],
        'warning' => [
            'wrap' => 'bg-amber-50 ring-amber-600/10 text-amber-800',
            'icon' => 'text-amber-600',
            'title' => 'text-amber-900',
            'close' => 'text-amber-600 hover:bg-amber-100',
        ],
        'info' => [
            'wrap' => 'bg-accent-50 ring-accent-600/10 text-accent-800',
            'icon' => 'text-accent-600',
            'title' => 'text-accent-900',
            'close' => 'text-accent-600 hover:bg-accent-100',
        ],
    ];

    $v = $variants[$variant] ?? $variants['info'];
@endphp

<div
    @if ($dismissible) x-data="{ show: true }" x-show="show" x-cloak x-transition @endif
    {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-xl p-4 text-sm ring-1 '.$v['wrap']]) }}
>
    <div class="mt-0.5 shrink-0 {{ $v['icon'] }}">
        @if ($variant === 'success')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        @elseif ($variant === 'error')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        @elseif ($variant === 'warning')
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        @else
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        @endif
    </div>

    <div class="min-w-0 flex-1">
        @if ($title)
            <p class="font-semibold {{ $v['title'] }}">{{ $title }}</p>
        @endif
        <div class="{{ $title ? 'mt-1' : '' }}">{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            @click="show = false"
            class="-m-1 ml-1 shrink-0 rounded-lg p-1 transition {{ $v['close'] }}"
            aria-label="Tutup"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
