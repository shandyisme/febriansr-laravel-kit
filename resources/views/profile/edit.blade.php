<x-layouts.dashboard title="Profil">
    <div class="mx-auto max-w-2xl space-y-6">
        {{-- Update profile information --}}
        <x-card title="Informasi Profil" subtitle="Perbarui nama dan alamat email akun Anda.">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <x-input
                    label="Nama"
                    name="name"
                    type="text"
                    :value="old('name', $user->name)"
                    autocomplete="name"
                    required
                />

                <x-input
                    label="Email"
                    name="email"
                    type="email"
                    :value="old('email', $user->email)"
                    autocomplete="email"
                    required
                />

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>

        {{-- Change password --}}
        <x-card title="Ubah Kata Sandi" subtitle="Gunakan kata sandi yang panjang dan acak agar tetap aman.">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <x-input
                    label="Kata Sandi Saat Ini"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    required
                />

                <x-input
                    label="Kata Sandi Baru"
                    name="password"
                    type="password"
                    hint="Minimal 8 karakter."
                    autocomplete="new-password"
                    required
                />

                <x-input
                    label="Konfirmasi Kata Sandi Baru"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required
                />

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">Perbarui Kata Sandi</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.dashboard>
