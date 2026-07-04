<x-layouts.auth title="Masuk">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Masuk ke akun Anda</h1>
        <p class="mt-1 text-sm text-slate-500">Selamat datang kembali. Silakan masukkan kredensial Anda.</p>
    </div>

    @if (session('status'))
        <x-alert variant="success" class="mb-5">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
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

        <x-input
            label="Kata Sandi"
            name="password"
            type="password"
            autocomplete="current-password"
            required
        />

        <div class="flex items-center justify-between gap-3">
            <label for="remember" class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    value="1"
                    class="h-4 w-4 rounded border-slate-300 text-brand-600 shadow-sm focus:ring-2 focus:ring-brand-500"
                />
                Ingat saya
            </label>

            <x-button variant="ghost" size="sm" :href="route('password.request')">
                Lupa kata sandi?
            </x-button>
        </div>

        <x-button type="submit" variant="primary" class="w-full">Masuk</x-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-500">Daftar sekarang</a>
        </p>
    @endif
</x-layouts.auth>
