@php
    $statusMap = [
        'active' => ['variant' => 'green', 'label' => 'Aktif'],
        'pending' => ['variant' => 'amber', 'label' => 'Menunggu'],
        'inactive' => ['variant' => 'gray', 'label' => 'Nonaktif'],
    ];
@endphp

<x-layouts.dashboard title="Data Anggota" :breadcrumbs="[['label' => 'Contoh'], ['label' => 'Data Table']]">
    <x-slot:actions>
        <x-dropdown align="right">
            <x-slot:trigger>
                <x-button variant="outline" size="md">Ekspor</x-button>
            </x-slot:trigger>
            <x-dropdown.item :href="route('exports.members', ['format' => 'csv'])">CSV</x-dropdown.item>
            <x-dropdown.item :href="route('exports.members', ['format' => 'xlsx'])">Excel</x-dropdown.item>
            <x-dropdown.item :href="route('exports.members', ['format' => 'pdf'])">PDF</x-dropdown.item>
        </x-dropdown>
        <x-button :href="route('samples.form')">Tambah Anggota</x-button>
    </x-slot:actions>

    <x-card :padding="''">
        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-xs">
                <input type="search" placeholder="Cari anggota…"
                    class="w-full rounded-xl border-0 py-2 pl-9 pr-3 text-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-brand-500">
                <svg class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34M17 10a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <span class="text-xs text-slate-400">{{ $members->total() }} anggota</span>
        </div>

        @if ($members->isEmpty())
            <x-empty-state title="Belum ada anggota" description="Tambahkan anggota pertama Anda.">
                <x-button :href="route('samples.form')" class="mt-4">Tambah Anggota</x-button>
            </x-empty-state>
        @else
            <x-table :headers="['Nama', 'Peran', 'Status', 'Bergabung', '']">
                @foreach ($members as $m)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <x-avatar :name="$m['name']" size="sm" />
                                <div>
                                    <div class="font-medium text-slate-900">{{ $m['name'] }}</div>
                                    <div class="text-xs text-slate-500">{{ $m['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><x-badge variant="accent">{{ $m['role'] }}</x-badge></td>
                        <td class="px-4 py-3">
                            <x-badge :variant="$statusMap[$m['status']]['variant']">{{ $statusMap[$m['status']]['label'] }}</x-badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-500">{{ $m['joined'] }}</td>
                        <td class="px-4 py-3 text-right">
                            <x-dropdown align="right" width="w-40">
                                <x-slot:trigger>
                                    <button class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 13.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 20.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" /></svg>
                                    </button>
                                </x-slot:trigger>
                                <x-dropdown.item :href="route('samples.form')">Lihat detail</x-dropdown.item>
                                <x-dropdown.item :href="route('samples.form')">Edit</x-dropdown.item>
                                <x-dropdown.item class="text-red-600 hover:bg-red-50">Hapus</x-dropdown.item>
                            </x-dropdown>
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <div class="border-t border-slate-100 p-4">
                <x-pagination :paginator="$members" />
            </div>
        @endif
    </x-card>
</x-layouts.dashboard>
