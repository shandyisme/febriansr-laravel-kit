<x-layouts.auth title="Atur Ulang Kata Sandi">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Atur ulang kata sandi</h1>
        <p class="mt-1 text-sm text-slate-500">Pilih kata sandi baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />

        <x-input
            label="Email"
            name="email"
            type="email"
            :value="old('email', $email)"
            autocomplete="email"
            required
        />

        <x-input
            label="Kata Sandi Baru"
            name="password"
            type="password"
            hint="Minimal 8 karakter."
            autocomplete="new-password"
            autofocus
            required
        />

        <x-input
            label="Konfirmasi Kata Sandi"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
            required
        />

        <x-button type="submit" variant="primary" class="w-full">Simpan Kata Sandi</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-500">Kembali ke masuk</a>
    </p>
</x-layouts.auth>
