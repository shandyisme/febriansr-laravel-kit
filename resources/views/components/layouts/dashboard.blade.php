@props([
    'title' => null,
    'breadcrumbs' => [],
])

@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
        ['label' => 'Data Table', 'route' => 'samples.table', 'icon' => 'M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m0 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m0 0h7.5m0-9v9'],
        ['label' => 'Form Detail', 'route' => 'samples.form', 'icon' => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10'],
        ['label' => 'Komponen', 'route' => 'samples.components', 'icon' => 'M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3'],
        ['label' => 'Alamat / Region', 'route' => 'samples.region', 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z'],
        ['label' => 'WhatsApp', 'route' => 'whatsapp.index', 'icon' => 'M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z'],
        ['label' => 'Impor Data', 'route' => 'samples.import', 'icon' => 'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5'],
        ['label' => 'Notifikasi', 'route' => 'notifications.index', 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],
        ['label' => 'Peran & Izin', 'route' => 'access.roles', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
        ['label' => 'Log Aktivitas', 'route' => 'access.activity', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Settings', 'route' => 'settings', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
    $logo = brand('logo_path');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <x-brand-head :title="$title" />
</head>
<body class="h-full text-slate-800 antialiased"
    x-data="{ sidebarOpen: false, collapsed: (localStorage.getItem('kitCollapsed') === '1') }"
    x-init="$watch('collapsed', v => localStorage.setItem('kitCollapsed', v ? '1' : '0'))">
    {{-- Ambient gradient backdrop — makes the glass surfaces above it read as glass. --}}
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-br from-brand-50 via-white to-accent-50"></div>
    <div class="pointer-events-none fixed -left-32 -top-32 -z-10 h-96 w-96 rounded-full bg-brand-200/30 blur-3xl"></div>
    <div class="pointer-events-none fixed -bottom-32 -right-32 -z-10 h-96 w-96 rounded-full bg-accent-200/30 blur-3xl"></div>

    {{-- Mobile off-canvas sidebar --}}
    <div x-show="sidebarOpen" x-cloak class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60" @click="sidebarOpen = false"></div>
        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="relative flex w-72 max-w-[80%] flex-col bg-white/85 pb-4 shadow-xl backdrop-blur-xl">
                <button type="button" class="absolute right-3 top-3 text-slate-400" @click="sidebarOpen = false">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <x-partials.sidebar :nav="$nav" :logo="$logo" />
            </div>
        </div>
    </div>

    {{-- Desktop sidebar --}}
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:flex-col lg:transition-[width] lg:duration-200"
        :class="collapsed ? 'lg:w-20' : 'lg:w-60'">
        <div class="flex grow flex-col border-r border-white/40 bg-white/60 backdrop-blur-xl">
            <x-partials.sidebar :nav="$nav" :logo="$logo" :collapsible="true" />
        </div>
    </div>

    <div class="lg:transition-[padding] lg:duration-200" :class="collapsed ? 'lg:pl-20' : 'lg:pl-60'">
        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-white/40 bg-white/60 px-4 backdrop-blur-xl sm:px-6 lg:px-8">
            <button type="button" class="text-slate-500 lg:hidden" @click="sidebarOpen = true" title="Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>

            {{-- Desktop: collapse/expand sidebar --}}
            <button type="button" class="hidden text-slate-500 hover:text-slate-700 lg:inline-flex" @click="collapsed = !collapsed"
                :title="collapsed ? 'Lebarkan sidebar' : 'Ciutkan sidebar'">
                <svg class="h-6 w-6 transition-transform duration-200" :class="collapsed && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 4.5l-7.5 7.5 7.5 7.5m-6-15l-7.5 7.5 7.5 7.5" /></svg>
            </button>

            <div class="flex flex-1 items-center justify-end gap-2">
                @auth
                    <x-partials.notifications-bell />

                    <x-dropdown align="right">
                        <x-slot:trigger>
                            <button class="flex items-center gap-2 rounded-full p-1 pr-2 hover:bg-slate-100">
                                <x-avatar :name="auth()->user()->name" size="sm" />
                                <span class="hidden text-sm font-medium text-slate-700 sm:block">{{ auth()->user()->name }}</span>
                            </button>
                        </x-slot:trigger>
                        <x-dropdown.item :href="route('profile.edit')">Profil</x-dropdown.item>
                        <x-dropdown.item :href="route('settings')">Pengaturan</x-dropdown.item>
                        <div class="my-1 border-t border-slate-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown.item type="submit">Keluar</x-dropdown.item>
                        </form>
                    </x-dropdown>
                @endauth
            </div>
        </header>

        {{-- Page header: breadcrumb + title + actions --}}
        <div class="border-b border-white/40 bg-white/40 px-4 py-5 backdrop-blur-xl sm:px-6 lg:px-8">
            @if (! empty($breadcrumbs))
                <x-breadcrumbs :items="$breadcrumbs" class="mb-2" />
            @endif
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    @if ($title)
                        <h1 class="text-xl font-bold text-slate-900">{{ $title }}</h1>
                    @endif
                    @isset($subtitle)
                        <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
                    @endisset
                </div>
                @isset($actions)
                    <div class="flex items-center gap-2">{{ $actions }}</div>
                @endisset
            </div>
        </div>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            <x-flash />
            {{ $slot }}
        </main>
    </div>

    @livewireScriptConfig
</body>
</html>
