<x-layouts.dashboard title="Komponen UI" :breadcrumbs="[['label' => 'Contoh'], ['label' => 'Komponen']]">

    <x-tabs :tabs="['dasar' => 'Dasar', 'form' => 'Form', 'umpanbalik' => 'Umpan Balik', 'data' => 'Data']">

        {{-- Dasar --}}
        <div x-show="active === 'dasar'" class="space-y-6">
            <x-card title="Tombol">
                <div class="flex flex-wrap items-center gap-3">
                    <x-button>Primary</x-button>
                    <x-button variant="secondary">Secondary</x-button>
                    <x-button variant="outline">Outline</x-button>
                    <x-button variant="ghost">Ghost</x-button>
                    <x-button variant="danger">Danger</x-button>
                    <x-button size="sm">Kecil</x-button>
                    <x-button size="lg">Besar</x-button>
                </div>
            </x-card>

            <x-card title="Badge">
                <div class="flex flex-wrap gap-2">
                    <x-badge variant="brand">Brand</x-badge>
                    <x-badge variant="accent">Accent</x-badge>
                    <x-badge variant="gray">Gray</x-badge>
                    <x-badge variant="green">Sukses</x-badge>
                    <x-badge variant="amber">Menunggu</x-badge>
                    <x-badge variant="red">Gagal</x-badge>
                </div>
            </x-card>

            <x-card title="Avatar">
                <div class="flex items-center gap-3">
                    <x-avatar name="Budi Santoso" size="sm" />
                    <x-avatar name="Siti Aminah" size="md" />
                    <x-avatar name="Ahmad Fauzi" size="lg" />
                </div>
            </x-card>
        </div>

        {{-- Form --}}
        <div x-show="active === 'form'" x-cloak class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-card title="Input & Select">
                <div class="space-y-4">
                    <x-input label="Nama" name="demo_name" placeholder="Masukkan nama" />
                    <x-input label="Email" name="demo_email" type="email" hint="Kami tidak membagikan email Anda." />
                    <x-select label="Kategori" name="demo_cat" :options="['a' => 'Kategori A', 'b' => 'Kategori B']" placeholder="Pilih kategori" />
                    <x-textarea label="Deskripsi" name="demo_desc" placeholder="Tulis sesuatu…" />
                </div>
            </x-card>
            <x-card title="Toggle">
                <div class="space-y-4">
                    <x-toggle label="Mode gelap" hint="Aktifkan tampilan gelap." />
                    <div class="border-t border-slate-100 pt-4">
                        <x-toggle label="Notifikasi email" :checked="true" />
                    </div>
                    <div class="border-t border-slate-100 pt-4">
                        <x-toggle label="Autosimpan" hint="Simpan otomatis tiap 30 detik." :checked="true" />
                    </div>
                </div>
            </x-card>

            <x-card title="Unggah Gambar" class="lg:col-span-2">
                <x-image-upload name="demo_image" label="" />
            </x-card>
        </div>

        {{-- Umpan balik --}}
        <div x-show="active === 'umpanbalik'" x-cloak class="space-y-6">
            <x-card title="Alert">
                <div class="space-y-3">
                    <x-alert variant="success" title="Berhasil">Data berhasil disimpan.</x-alert>
                    <x-alert variant="error" title="Gagal">Terjadi kesalahan, coba lagi.</x-alert>
                    <x-alert variant="warning" title="Perhatian" dismissible>Sesi Anda akan berakhir.</x-alert>
                    <x-alert variant="info">Ini informasi tambahan.</x-alert>
                </div>
            </x-card>

            <x-card title="Modal & Dropdown">
                <div class="flex flex-wrap items-center gap-3">
                    <x-button @click="$dispatch('open-modal', 'demo-modal')">Buka Modal</x-button>

                    <x-dropdown align="left">
                        <x-slot:trigger>
                            <x-button variant="outline">Menu Dropdown</x-button>
                        </x-slot:trigger>
                        <x-dropdown.item href="#">Aksi Satu</x-dropdown.item>
                        <x-dropdown.item href="#">Aksi Dua</x-dropdown.item>
                        <x-dropdown.item class="text-red-600 hover:bg-red-50">Hapus</x-dropdown.item>
                    </x-dropdown>
                </div>

                <x-modal name="demo-modal" title="Contoh Modal">
                    <p class="text-sm text-slate-600">Ini isi modal. Tutup dengan tombol di bawah, klik area gelap, atau tekan Escape.</p>
                    <x-slot:footer>
                        <x-button variant="outline" @click="$dispatch('close-modal')">Batal</x-button>
                        <x-button @click="$dispatch('close-modal')">Simpan</x-button>
                    </x-slot:footer>
                </x-modal>
            </x-card>
        </div>

        {{-- Data --}}
        <div x-show="active === 'data'" x-cloak class="space-y-6">
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <x-stat-card label="Pengguna" value="1.248" trend="12%" :trendUp="true" />
                <x-stat-card label="Pendapatan" value="Rp 24jt" trend="8%" :trendUp="true" />
                <x-stat-card label="Pesanan" value="342" trend="3%" :trendUp="false" />
                <x-stat-card label="Refund" value="12" />
            </div>
            <x-card title="Empty State">
                <x-empty-state title="Belum ada data" description="Data akan muncul di sini setelah ditambahkan.">
                    <x-button class="mt-4">Tambah Data</x-button>
                </x-empty-state>
            </x-card>
        </div>

    </x-tabs>
</x-layouts.dashboard>
