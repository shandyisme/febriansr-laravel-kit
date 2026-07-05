@php
    $user = auth()->user();
    $unread = $user ? $user->unreadNotifications()->count() : 0;
    $recent = $user ? $user->notifications()->latest()->limit(5)->get() : collect();
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
    <button
        type="button"
        @click="open = ! open"
        class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"
        aria-label="Notifikasi"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>

        @if ($unread > 0)
            <span class="absolute right-1.5 top-1.5 inline-flex min-w-4 items-center justify-center rounded-full bg-brand-600 px-1 text-[10px] font-semibold leading-4 text-white">
                {{ $unread > 99 ? '99+' : $unread }}
            </span>
        @endif
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 z-50 mt-2 w-80 rounded-xl bg-white p-1 shadow-lg ring-1 ring-slate-900/5"
    >
        <div class="flex items-center justify-between px-3 py-2">
            <span class="text-sm font-semibold text-slate-900">Notifikasi</span>
            @if ($unread > 0)
                <span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-[11px] font-medium text-brand-700">{{ $unread }} baru</span>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse ($recent as $n)
                <a
                    href="{{ $n->data['url'] ?? route('notifications.index') }}"
                    @class([
                        'flex gap-2.5 rounded-lg px-3 py-2.5 transition hover:bg-slate-50',
                        'bg-brand-50/40' => is_null($n->read_at),
                    ])
                >
                    <span @class([
                        'mt-1.5 h-2 w-2 shrink-0 rounded-full',
                        'bg-brand-500' => is_null($n->read_at),
                        'bg-transparent' => ! is_null($n->read_at),
                    ])></span>
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-medium text-slate-900">{{ $n->data['title'] ?? 'Notifikasi' }}</span>
                        @if (! empty($n->data['body']))
                            <span class="mt-0.5 block truncate text-xs text-slate-500">{{ $n->data['body'] }}</span>
                        @endif
                        <span class="mt-0.5 block text-[11px] text-slate-400">{{ \App\Support\DateFormatter::diffForHumansId($n->created_at) }}</span>
                    </span>
                </a>
            @empty
                <div class="px-3 py-6 text-center text-sm text-slate-400">Belum ada notifikasi.</div>
            @endforelse
        </div>

        <div class="border-t border-slate-100 px-3 py-2">
            <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-medium text-brand-600 hover:text-brand-700">Lihat semua</a>
        </div>
    </div>
</div>
