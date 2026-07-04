<x-layouts.dashboard title="Log Aktivitas" :breadcrumbs="[['label' => 'Akses'], ['label' => 'Aktivitas']]">
    <x-card :padding="''">
        @if ($logs->isEmpty())
            <x-empty-state title="Belum ada aktivitas" description="Aktivitas pengguna akan tercatat di sini." />
        @else
            <x-table :headers="['Waktu', 'Pengguna', 'Aktivitas', 'IP']">
                @foreach ($logs as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-500">
                            {{ \App\Support\DateFormatter::withTime($log->created_at) }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <x-avatar :name="$log->user?->name ?? 'Sistem'" size="sm" />
                                <span class="font-medium text-slate-900">{{ $log->user?->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-900">{{ $log->event }}</div>
                            @if ($log->description)
                                <div class="text-xs text-slate-500">{{ $log->description }}</div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-500">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                @endforeach
            </x-table>

            <div class="border-t border-slate-100 p-4">
                <x-pagination :paginator="$logs" />
            </div>
        @endif
    </x-card>
</x-layouts.dashboard>
