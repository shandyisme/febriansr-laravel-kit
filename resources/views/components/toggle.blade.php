@props([
    'name' => null,
    'label' => null,
    'hint' => null,
    'checked' => false,
])

@php $on = old($name, $checked) ? 'true' : 'false'; @endphp

<div x-data="{ on: {{ $on }} }" class="flex items-start justify-between gap-4">
    @if ($label || $hint)
        <div>
            @if ($label)<span class="text-sm font-medium text-slate-800">{{ $label }}</span>@endif
            @if ($hint)<p class="text-xs text-slate-500">{{ $hint }}</p>@endif
        </div>
    @endif

    <button type="button" role="switch" :aria-checked="on.toString()" @click="on = !on"
        :class="on ? 'bg-brand-600' : 'bg-slate-200'"
        {{ $attributes->merge(['class' => 'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-brand-500']) }}>
        <span :class="on ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition"></span>
    </button>

    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="on ? 1 : 0">
    @endif
</div>
