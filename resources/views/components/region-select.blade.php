@props([
    'name' => 'region',
    'label' => 'Alamat',
    'placeholder' => 'Ketik kelurahan / kecamatan / kota…',
    'value' => null,          // region id
    'selectedLabel' => null,  // display label for an already-selected value
    'hint' => null,
])

<div class="relative"
    x-data="regionSelect(@js(route('regions.search')), @js(old($name, $value)), @js($selectedLabel))"
    @click.outside="open = false">

    @if ($label)
        <label class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif

    <div class="relative">
        <input type="text" x-model="query" @input.debounce.300ms="search()" @focus="query.trim().length >= 3 && (open = true)"
            autocomplete="off" placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full rounded-xl border-0 py-2.5 pl-3 pr-9 text-sm text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-brand-500']) }}>

        <input type="hidden" name="{{ $name }}" :value="selectedId">

        {{-- Spinner / clear --}}
        <div class="absolute right-2.5 top-2.5">
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin text-slate-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <button type="button" x-show="!loading && query.length" x-cloak @click="clear()" class="text-slate-400 hover:text-slate-600" title="Bersihkan">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Results --}}
        <div x-show="open && results.length" x-cloak x-transition.opacity
            class="absolute z-50 mt-1 max-h-72 w-full overflow-auto rounded-xl bg-white/95 p-1 shadow-lg ring-1 ring-slate-900/5 backdrop-blur">
            <template x-for="r in results" :key="r.id">
                <button type="button" @click="choose(r)"
                    class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 text-left text-sm transition hover:bg-brand-50">
                    <span class="text-slate-800" x-text="r.label"></span>
                    <span x-show="r.zip" class="shrink-0 text-xs text-slate-400" x-text="r.zip"></span>
                </button>
            </template>
        </div>

        {{-- Empty --}}
        <div x-show="open && !results.length && !loading && query.trim().length >= 3" x-cloak
            class="absolute z-50 mt-1 w-full rounded-xl bg-white p-3 text-sm text-slate-400 shadow-lg ring-1 ring-slate-900/5">
            Tidak ada hasil untuk "<span x-text="query"></span>".
        </div>
    </div>

    @if ($hint)
        <p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
