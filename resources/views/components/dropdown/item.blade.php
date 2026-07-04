@props([
    'href' => null,
    'type' => 'button',
])

@php
    $classes = 'block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-50';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
