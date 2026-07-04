<x-layouts.dashboard title="Detail Anggota" :breadcrumbs="[['label' => 'Contoh'], ['label' => 'Data Table', 'href' => route('samples.table')], ['label' => 'Form']]">
    <x-slot:actions>
        <x-button variant="outline" :href="route('samples.table')">Batal</x-button>
        <x-button type="submit" form="member-form">Simpan</x-button>
    </x-slot:actions>

    <form id="member-form" action="#" method="POST" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        @csrf

        {{-- Main column --}}
        <div class="space-y-6 lg:col-span-2">
            <x-card title="Informasi Dasar" subtitle="Data identitas anggota.">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-input label="Nama Lengkap" name="name" value="Budi Santoso" required />
                    <x-input label="Email" name="email" type="email" value="budi.santoso@contoh.id" required />
                    <x-input label="No. WhatsApp" name="phone" value="0812-3456-7890" hint="Format bebas, dinormalisasi ke 62…" />
                    <x-select label="Peran" name="role" :options="['admin' => 'Admin', 'manajer' => 'Manajer', 'staf' => 'Staf', 'editor' => 'Editor']" selected="staf" />
                </div>
                <div class="mt-5">
                    <x-textarea label="Catatan" name="notes" placeholder="Catatan internal…" />
                </div>
            </x-card>

            <x-card title="Alamat">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-input label="Alamat" name="address" placeholder="Jl. Contoh No. 123" />
                    </div>
                    <x-input label="Kota" name="city" value="Jakarta" />
                    <x-select label="Provinsi" name="province" :options="['dki' => 'DKI Jakarta', 'jabar' => 'Jawa Barat', 'jateng' => 'Jawa Tengah', 'jatim' => 'Jawa Timur']" selected="dki" />
                </div>
            </x-card>
        </div>

        {{-- Sidebar column --}}
        <div class="space-y-6">
            <x-card title="Status & Preferensi">
                <div class="space-y-5">
                    <x-select label="Status" name="status" :options="['active' => 'Aktif', 'pending' => 'Menunggu', 'inactive' => 'Nonaktif']" selected="active" />
                    <div class="border-t border-slate-100 pt-4">
                        <x-toggle name="is_verified" label="Terverifikasi" hint="Tandai anggota terpercaya." :checked="true" />
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <x-toggle name="notify_wa" label="Notifikasi WhatsApp" hint="Kirim pemberitahuan via WA." :checked="true" />
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <x-toggle name="newsletter" label="Langganan Newsletter" hint="Email berkala." />
                    </div>
                </div>
            </x-card>

            <x-card title="Foto Profil">
                <div class="flex items-center gap-4">
                    <x-avatar name="Budi Santoso" size="lg" />
                    <x-button variant="outline" size="sm">Unggah Foto</x-button>
                </div>
            </x-card>
        </div>
    </form>
</x-layouts.dashboard>
