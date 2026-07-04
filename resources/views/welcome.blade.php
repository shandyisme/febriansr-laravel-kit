<x-layouts.public title="Selamat Datang">
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10 bg-gradient-to-b from-brand-50 via-white to-slate-50"></div>

        <div class="mx-auto max-w-6xl px-4 py-20 text-center sm:px-6 lg:px-8 lg:py-28">
            <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-inset ring-brand-200">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                Laravel 13 · Livewire 4 · Tailwind v4
            </span>

            <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                Bangun aplikasi lebih cepat dengan
                <span class="bg-gradient-to-r from-brand-500 to-accent-500 bg-clip-text text-transparent">Febrian Laravel Kit</span>
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600">
                Boilerplate produksi yang bersih dan mobile-first: autentikasi, dashboard,
                komponen UI siap pakai, dan sistem brand white-label — semua sudah terpasang
                agar Anda fokus membangun fitur, bukan fondasi.
            </p>

            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <x-button :href="route('login')" size="lg">
                    Mulai Sekarang
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </x-button>
                <x-button href="#fitur" variant="outline" size="lg">Pelajari Fitur</x-button>
            </div>
        </div>
    </section>

    {{-- Feature row --}}
    <section id="fitur" class="mx-auto max-w-6xl px-4 pb-24 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @php
                $features = [
                    [
                        'title' => 'Komponen Siap Pakai',
                        'desc' => 'Button, card, table, form, modal, dan lainnya — konsisten, aksesibel, dan mudah dikustomisasi.',
                        'icon' => 'M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3',
                    ],
                    [
                        'title' => 'Brand White-label',
                        'desc' => 'Ganti warna, logo, dan nama aplikasi dari satu file konfigurasi. Cocok untuk banyak klien.',
                        'icon' => 'M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42',
                    ],
                    [
                        'title' => 'Siap Produksi',
                        'desc' => 'Struktur service layer, response API konsisten, helper Indonesia, dan test bawaan.',
                        'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <x-card class="text-left">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $feature['desc'] }}</p>
                </x-card>
            @endforeach
        </div>

        {{-- CTA strip --}}
        <div class="mt-12 overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-brand-500 px-6 py-10 text-center shadow-sm sm:px-12">
            <h2 class="text-2xl font-bold text-white sm:text-3xl">Siap membangun produk berikutnya?</h2>
            <p class="mx-auto mt-3 max-w-xl text-brand-50">
                Masuk ke dashboard dan mulai eksplorasi seluruh komponen serta halaman contoh.
            </p>
            <div class="mt-6 flex justify-center">
                <x-button :href="route('login')" variant="outline" size="lg">Masuk ke Dashboard</x-button>
            </div>
        </div>
    </section>
</x-layouts.public>
