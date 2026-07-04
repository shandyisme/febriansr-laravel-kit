@props([
    'label' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

@php
    $id = $attributes->get('id', $name);
    $current = old($name, $selected);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'w-full rounded-xl bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500']) }}
    >
        @if ($placeholder)
            <option value="" @selected($current === null || $current === '')>{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected((string) $current === (string) $value)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if ($name)
        @error($name)
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    @endif
</div>
