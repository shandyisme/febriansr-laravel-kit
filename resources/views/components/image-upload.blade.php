@props([
    'name' => 'image',
    'label' => 'Gambar',
    'value' => null,      // existing image URL (edit mode)
    'hint' => 'PNG, JPG, atau WEBP — seret atau klik untuk memilih.',
    'height' => 'h-40',   // preview size
])

<div x-data="imageUpload(@js($value))">
    @if ($label)
        <label class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif

    <div
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="onDrop($event)"
        @click="$refs.input.click()"
        :class="dragging ? 'border-brand-400 bg-brand-50/60' : 'border-slate-300 bg-white/40'"
        class="relative flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed p-6 text-center backdrop-blur-sm transition hover:border-brand-300">

        <input x-ref="input" type="file" name="{{ $name }}" accept="image/*" class="hidden" @change="onPick($event)">

        {{-- Preview --}}
        <template x-if="preview">
            <div class="w-full" @click.stop>
                <img :src="preview" alt="" class="mx-auto {{ $height }} w-auto max-w-full rounded-xl object-cover shadow-sm ring-1 ring-slate-200">
                <div class="mt-2 flex items-center justify-center gap-1.5 text-xs text-slate-500">
                    <span class="max-w-[16rem] truncate" x-text="fileName || 'Gambar saat ini'"></span>
                    <span x-show="fileSize" x-text="'· ' + fileSize"></span>
                </div>
                <div class="mt-3 flex justify-center gap-2">
                    <button type="button" @click.stop="$refs.input.click()"
                        class="rounded-lg bg-white px-3 py-1.5 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50">Ganti</button>
                    <button type="button" @click.stop="clear()"
                        class="rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">Hapus</button>
                </div>
            </div>
        </template>

        {{-- Empty state --}}
        <template x-if="!preview">
            <div class="pointer-events-none flex flex-col items-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" /></svg>
                </span>
                <p class="mt-3 text-sm text-slate-600">Seret &amp; letakkan gambar, atau <span class="font-medium text-brand-600">pilih file</span></p>
                <p class="mt-0.5 text-xs text-slate-400">{{ $hint }}</p>
            </div>
        </template>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
