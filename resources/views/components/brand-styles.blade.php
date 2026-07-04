{{-- Injects brand colour tokens from config/brand.php as CSS variables,
     overriding the Tailwind @theme defaults so the whole UI recolours from config. --}}
@php
    $brandColors = brand('colors.brand', []);
    $accentColors = brand('colors.accent', []);
@endphp
<style>
    :root {
        @foreach ($brandColors as $shade => $hex)--color-brand-{{ $shade }}: {{ $hex }}; @endforeach
        @foreach ($accentColors as $shade => $hex)--color-accent-{{ $shade }}: {{ $hex }}; @endforeach
    }
</style>
