@props([
    'tabs' => [],
    'default' => null,
])

@php $first = $default ?? array_key_first($tabs); @endphp

<div x-data="{ active: @js($first) }" {{ $attributes }}>
    <div class="flex gap-1 overflow-x-auto border-b border-slate-200">
        @foreach ($tabs as $id => $label)
            <button type="button" @click="active = @js($id)"
                :class="active === @js($id) ? 'border-brand-600 text-brand-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="-mb-px whitespace-nowrap border-b-2 px-4 py-2.5 text-sm font-medium transition">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- Panels: wrap each in <div x-show="active === 'id'"> --}}
    <div class="pt-5">
        {{ $slot }}
    </div>
</div>
