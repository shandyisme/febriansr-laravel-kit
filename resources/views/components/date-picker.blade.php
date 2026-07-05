@props([
    'name' => 'date',
    'label' => null,
    'value' => null,
    'placeholder' => 'Pilih tanggal',
    'hint' => null,
    'options' => [],   // extra flatpickr options
])

@php
    $opts = array_merge(['dateFormat' => 'Y-m-d', 'altInput' => true, 'altFormat' => 'd M Y'], $options);
@endphp

<div>
    @if ($label)
        <label class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif

    <div x-data="datePicker(@js($opts))">
        <input x-ref="input" type="text" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
            class="w-full rounded-xl border-0 bg-white px-3 py-2.5 text-sm text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-brand-500">
    </div>

    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
