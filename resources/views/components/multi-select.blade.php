@props([
    'name' => 'items',
    'label' => null,
    'options' => [],     // [value => label] or [['value'=>..,'label'=>..], ...]
    'selected' => [],
    'placeholder' => 'Pilih…',
])

@php
    $opts = [];
    foreach ($options as $k => $v) {
        $opts[] = is_array($v) ? $v : ['value' => (string) $k, 'label' => (string) $v];
    }
    $sel = array_map('strval', (array) old($name, $selected));
@endphp

<div x-data="multiSelect(@js($opts), @js($sel))" @click.outside="open = false" class="relative">
    @if ($label)
        <label class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif

    <div @click="open = true"
        class="flex min-h-[2.75rem] w-full cursor-text flex-wrap items-center gap-1.5 rounded-xl bg-white px-2 py-1.5 ring-1 ring-inset ring-slate-300 focus-within:ring-2 focus-within:ring-brand-500">
        <template x-for="v in selected" :key="v">
            <span class="inline-flex items-center gap-1 rounded-lg bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700">
                <span x-text="labelFor(v)"></span>
                <button type="button" @click.stop="remove(v)" class="text-brand-400 hover:text-brand-700">&times;</button>
                <input type="hidden" name="{{ $name }}[]" :value="v">
            </span>
        </template>
        <input x-model="query" @focus="open = true" type="text" placeholder="{{ $placeholder }}"
            class="flex-1 border-0 bg-transparent p-1 text-sm outline-none focus:ring-0">
    </div>

    <div x-show="open && filtered.length" x-cloak
        class="absolute z-50 mt-1 max-h-56 w-full overflow-auto rounded-xl bg-white p-1 shadow-lg ring-1 ring-slate-900/5">
        <template x-for="o in filtered" :key="o.value">
            <button type="button" @click="add(o.value)" class="block w-full rounded-lg px-3 py-2 text-left text-sm hover:bg-brand-50" x-text="o.label"></button>
        </template>
    </div>
</div>
