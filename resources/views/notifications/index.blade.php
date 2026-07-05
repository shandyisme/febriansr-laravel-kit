<x-layouts.dashboard title="Notifikasi" :breadcrumbs="[['label' => 'Notifikasi']]">
    <x-slot:actions>
        <form method="POST" action="{{ route('notifications.sendDemo') }}">
            @csrf
            <x-button type="submit" variant="outline" size="md">Kirim Uji</x-button>
        </form>
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <x-button type="submit" size="md">Tandai semua dibaca</x-button>
        </form>
    </x-slot:actions>

    @if ($notifications->isEmpty())
        <x-card :padding="''">
            <x-empty-state title="Belum ada notifikasi" description="Notifikasi Anda akan muncul di sini." />
        </x-card>
    @else
        <div class="space-y-3">
            @foreach ($notifications as $n)
                @php $unread = is_null($n->read_at); @endphp
                <div @class([
                    'rounded-2xl bg-white p-4 ring-1 ring-slate-900/5 shadow-sm',
                    'ring-brand-200 bg-brand-50/40' => $unread,
                ])>
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                @if ($unread)
                                    <span class="h-2 w-2 shrink-0 rounded-full bg-brand-500"></span>
                                @endif
                                <h3 class="font-semibold text-slate-900">{{ $n->data['title'] ?? 'Notifikasi' }}</h3>
                            </div>
                            @if (! empty($n->data['body']))
                                <p class="mt-1 text-sm text-slate-600">{{ $n->data['body'] }}</p>
                            @endif
                            <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-400">
                                <span>{{ \App\Support\DateFormatter::diffForHumansId($n->created_at) }}</span>
                                @if (! empty($n->data['url']))
                                    <a href="{{ $n->data['url'] }}" class="font-medium text-brand-600 hover:text-brand-700">Buka</a>
                                @endif
                            </div>
                        </div>

                        @if ($unread)
                            <form method="POST" action="{{ route('notifications.read', $n->id) }}" class="shrink-0">
                                @csrf
                                <x-button type="submit" variant="ghost" size="sm">Tandai dibaca</x-button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <x-pagination :paginator="$notifications" />
        </div>
    @endif
</x-layouts.dashboard>
