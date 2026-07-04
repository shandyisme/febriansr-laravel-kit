<x-layouts.dashboard title="Pengaturan">
    <form method="POST" action="{{ route('settings.update') }}" class="mx-auto grid max-w-3xl grid-cols-1 gap-6">
        @csrf
        @method('PUT')

        {{-- General settings --}}
        <x-card title="Umum" subtitle="Informasi dasar aplikasi">
            <div class="grid grid-cols-1 gap-5">
                <x-input
                    label="Nama Aplikasi"
                    name="app_name"
                    :value="old('app_name', setting('app_name', brand('app_name')))"
                    placeholder="Febrian Laravel Kit"
                    hint="Ditampilkan pada judul halaman dan email."
                    required
                />

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-select
                        label="Zona Waktu"
                        name="timezone"
                        :selected="old('timezone', setting('timezone', 'Asia/Jakarta'))"
                        :options="[
                            'Asia/Jakarta' => 'WIB — Asia/Jakarta',
                            'Asia/Makassar' => 'WITA — Asia/Makassar',
                            'Asia/Jayapura' => 'WIT — Asia/Jayapura',
                        ]"
                    />

                    <x-select
                        label="Bahasa"
                        name="locale"
                        :selected="old('locale', setting('locale', 'id'))"
                        :options="['id' => 'Bahasa Indonesia', 'en' => 'English']"
                    />
                </div>

                <x-input
                    label="Email Kontak"
                    name="contact_email"
                    type="email"
                    :value="old('contact_email', setting('contact_email', 'halo@febriansr.id'))"
                    placeholder="halo@contoh.id"
                />
            </div>
        </x-card>

        {{-- Localization / format --}}
        <x-card title="Format & Notifikasi" subtitle="Preferensi tampilan angka, tanggal, dan pemberitahuan">
            <div class="grid grid-cols-1 gap-5">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-select
                        label="Mata Uang"
                        name="currency"
                        :selected="old('currency', setting('currency', 'IDR'))"
                        :options="['IDR' => 'Rupiah (Rp)', 'USD' => 'US Dollar ($)']"
                    />

                    <x-select
                        label="Format Tanggal"
                        name="date_format"
                        :selected="old('date_format', setting('date_format', 'd M Y'))"
                        :options="[
                            'd M Y' => now()->format('d M Y'),
                            'd F Y' => now()->format('d F Y'),
                            'd/m/Y' => now()->format('d/m/Y'),
                        ]"
                    />
                </div>

                <div class="rounded-xl bg-slate-50/70 px-4 py-3">
                    <x-toggle
                        name="wa_notifications"
                        label="Notifikasi WhatsApp"
                        hint="Kirim notifikasi penting via WhatsApp."
                        :checked="setting('wa_notifications', true)"
                    />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit">Simpan Perubahan</x-button>
        </div>
    </form>
</x-layouts.dashboard>
