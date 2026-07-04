<x-layouts.dashboard title="Pengaturan">
    <div class="mx-auto grid max-w-3xl grid-cols-1 gap-6">
        {{-- General settings --}}
        <x-card title="Umum" subtitle="Informasi dasar aplikasi">
            <form method="POST" action="#" class="grid grid-cols-1 gap-5">
                @csrf

                <x-input
                    label="Nama Aplikasi"
                    name="app_name"
                    :value="old('app_name', brand('app_name'))"
                    placeholder="Febrian Laravel Kit"
                    hint="Ditampilkan pada judul halaman dan email."
                />

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-select
                        label="Zona Waktu"
                        name="timezone"
                        :selected="old('timezone', 'Asia/Jakarta')"
                        :options="[
                            'Asia/Jakarta' => 'WIB — Asia/Jakarta',
                            'Asia/Makassar' => 'WITA — Asia/Makassar',
                            'Asia/Jayapura' => 'WIT — Asia/Jayapura',
                        ]"
                    />

                    <x-select
                        label="Bahasa"
                        name="locale"
                        :selected="old('locale', 'id')"
                        :options="[
                            'id' => 'Bahasa Indonesia',
                            'en' => 'English',
                        ]"
                    />
                </div>

                <x-input
                    label="Email Kontak"
                    name="contact_email"
                    type="email"
                    :value="old('contact_email', 'halo@febriansr.id')"
                    placeholder="halo@contoh.id"
                />

                <div class="flex justify-end">
                    <x-button type="submit">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>

        {{-- Localization / format --}}
        <x-card title="Format & Mata Uang" subtitle="Preferensi tampilan angka dan tanggal">
            <form method="POST" action="#" class="grid grid-cols-1 gap-5">
                @csrf

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-select
                        label="Mata Uang"
                        name="currency"
                        :selected="old('currency', 'IDR')"
                        :options="[
                            'IDR' => 'Rupiah (Rp)',
                            'USD' => 'US Dollar (\$)',
                        ]"
                    />

                    <x-select
                        label="Format Tanggal"
                        name="date_format"
                        :selected="old('date_format', 'd M Y')"
                        :options="[
                            'd M Y' => '4 Jul 2026',
                            'd F Y' => '4 Juli 2026',
                            'd/m/Y' => '04/07/2026',
                        ]"
                    />
                </div>

                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Notifikasi WhatsApp</p>
                        <p class="text-xs text-slate-500">Kirim notifikasi penting via WhatsApp.</p>
                    </div>
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" name="wa_notifications" value="1" class="peer sr-only" checked>
                        <span class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-brand-500"></span>
                        <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.dashboard>
