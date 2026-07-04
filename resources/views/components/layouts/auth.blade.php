@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <x-brand-head :title="$title" />
</head>
<body class="relative grid min-h-full place-items-center overflow-hidden bg-gradient-to-br from-brand-50 via-white to-accent-50 px-4 py-12 text-slate-800 antialiased">
    <div class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-brand-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-accent-200/40 blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        {{-- Brand --}}
        <div class="mb-6 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                @if (brand('logo_path'))
                    <img src="{{ asset(brand('logo_path')) }}" alt="{{ brand('app_name') }}" class="h-9 w-auto">
                @else
                    <span class="text-2xl font-bold text-brand-600">{{ brand('logo_text') }}</span>
                @endif
            </a>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl bg-white/70 p-8 shadow-xl shadow-slate-200/50 ring-1 ring-white/50 backdrop-blur-xl">
            {{ $slot }}
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} {{ brand('app_name') }}
        </p>
    </div>

    @livewireScriptConfig
</body>
</html>
