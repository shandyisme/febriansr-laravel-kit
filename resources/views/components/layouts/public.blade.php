@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <x-brand-head :title="$title" />
</head>
<body class="flex min-h-full flex-col bg-slate-50 text-slate-800 antialiased">
    {{-- Top navigation --}}
    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/80 backdrop-blur">
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
    <footer class="border-t border-slate-200 bg-white">
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
