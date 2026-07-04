@props([
    'name' => '',
    'src' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $words = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY);
    $initials = '';
    foreach (array_slice($words, 0, 2) as $word) {
        $initials .= mb_substr($word, 0, 1);
    }
    $initials = mb_strtoupper($initials);
@endphp

@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $name }}"
        {{ $attributes->merge(['class' => 'shrink-0 rounded-full object-cover '.$sizeClass]) }}
    />
@else
    <span
        {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center justify-center rounded-full bg-brand-100 font-semibold text-brand-700 '.$sizeClass]) }}
    >{{ $initials }}</span>
@endif
