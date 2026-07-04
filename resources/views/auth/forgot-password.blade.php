<x-layouts.auth title="Lupa Kata Sandi">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Lupa kata sandi?</h1>
        <p class="mt-1 text-sm text-slate-500">
            Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
        </p>
    </div>

    @if (session('status'))
        <x-alert variant="success" class="mb-5">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-input
            label="Email"
            name="email"
            type="email"
            :value="old('email')"
            autocomplete="email"
            autofocus
            required
        />

        <x-button type="submit" variant="primary" class="w-full">Kirim Tautan Reset</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Ingat kata sandi Anda?
        <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-500">Kembali ke masuk</a>
    </p>
</x-layouts.auth>
