@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <x-brand-head :title="$title" />
</head>
<body class="flex min-h-full flex-col text-slate-800 antialiased">
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-br from-brand-50 via-white to-accent-50"></div>
    <div class="pointer-events-none fixed -left-40 -top-40 -z-10 h-[32rem] w-[32rem] rounded-full bg-brand-200/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -right-40 bottom-0 -z-10 h-[32rem] w-[32rem] rounded-full bg-accent-200/30 blur-3xl"></div>

    {{-- Top navigation --}}
    <header class="sticky top-0 z-40 border-b border-white/40 bg-white/60 backdrop-blur-xl">
        <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg font-bold text-brand-600">
                @if (brand('logo_path'))
                    <img src="{{ asset(brand('logo_path')) }}" alt="{{ brand('app_name') }}" class="h-8 w-auto">
                @else
                    {{ brand('logo_text') }}
                @endif
            </a>

            <div class="flex items-center gap-2">
                @auth
                    <x-button :href="route('dashboard')" size="sm">Dashboard</x-button>
                @else
                    <x-button :href="route('login')" variant="ghost" size="sm">Masuk</x-button>
                    @if (Route::has('register'))
                        <x-button :href="route('register')" size="sm">Daftar</x-button>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    {{-- Page content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/40 bg-white/50 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} {{ brand('app_name') }}. Semua hak dilindungi.</p>
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="transition hover:text-brand-600">Beranda</a>
                <a href="{{ route('login') }}" class="transition hover:text-brand-600">Masuk</a>
            </div>
        </div>
    </footer>

    @livewireScriptConfig
</body>
</html>
