@props([
    'variant' => 'gray',
])

@php
    $variants = [
        'brand' => 'bg-brand-50 text-brand-700',
        'accent' => 'bg-accent-50 text-accent-700',
        'gray' => 'bg-slate-100 text-slate-700',
        'green' => 'bg-green-50 text-green-700',
        'red' => 'bg-red-50 text-red-700',
        'amber' => 'bg-amber-50 text-amber-700',
    ];

    $classes = 'inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium '
        .($variants[$variant] ?? $variants['gray']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>
