@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <x-brand-head :title="$title" />
</head>
<body class="grid min-h-full place-items-center bg-slate-50 px-4 py-12 text-slate-800 antialiased">
    <div class="w-full max-w-md">
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
        <div class="rounded-2xl bg-white p-8 shadow-xl ring-1 ring-slate-900/5">
            {{ $slot }}
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} {{ brand('app_name') }}
        </p>
    </div>

    @livewireScriptConfig
</body>
</html>
