<x-layouts.auth title="Daftar">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Buat akun baru</h1>
        <p class="mt-1 text-sm text-slate-500">Lengkapi data berikut untuk mulai menggunakan {{ brand('app_name') }}.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-input
            label="Nama"
            name="name"
            type="text"
            :value="old('name')"
            autocomplete="name"
            autofocus
            required
        />

        <x-input
            label="Email"
            name="email"
            type="email"
            :value="old('email')"
            autocomplete="email"
            required
        />

        <x-input
            label="Kata Sandi"
            name="password"
            type="password"
            hint="Minimal 8 karakter."
            autocomplete="new-password"
            required
        />

        <x-input
            label="Konfirmasi Kata Sandi"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
            required
        />

        <x-button type="submit" variant="primary" class="w-full">Daftar</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-500">Masuk di sini</a>
    </p>
</x-layouts.auth>
