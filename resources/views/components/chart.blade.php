@props([
    'type' => 'bar',    // bar | line | doughnut | pie | ...
    'data' => [],        // Chart.js data object
    'options' => [],     // Chart.js options (merged over sensible defaults)
    'height' => 'h-64',
])

@php
    $config = [
        'type' => $type,
        'data' => $data,
        'options' => array_replace_recursive([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => ['legend' => ['display' => true, 'position' => 'bottom']],
        ], $options),
    ];
@endphp

<div x-data="chartBox(@js($config))" {{ $attributes->merge(['class' => $height.' w-full']) }}>
    <canvas x-ref="canvas"></canvas>
</div>
