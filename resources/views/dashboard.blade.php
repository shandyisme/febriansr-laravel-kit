<x-layouts.dashboard title="Dashboard">
    <x-slot:actions>
        <x-button>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah
        </x-button>
    </x-slot:actions>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card
            label="Pengguna"
            value="2.480"
            trend="12,5%"
            :trend-up="true"
            :icon="'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.8\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21 12.282 12.282 0 013 19.235v-.11a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z\' /></svg>'"
        />
        <x-stat-card
            label="Pendapatan"
            value="Rp 152,4 jt"
            trend="8,1%"
            :trend-up="true"
            :icon="'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.8\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z\' /></svg>'"
        />
        <x-stat-card
            label="Pesanan"
            value="1.024"
            trend="3,2%"
            :trend-up="false"
            :icon="'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.8\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z\' /></svg>'"
        />
        <x-stat-card
            label="Aktivitas"
            value="98,6%"
            trend="1,4%"
            :trend-up="true"
            :icon="'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.8\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z\' /></svg>'"
        />
    </div>

    {{-- Two-column: recent activity + summary --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Recent activity table --}}
        <div class="lg:col-span-2">
            <x-card title="Aktivitas Terbaru" subtitle="7 hari terakhir">
                <x-slot:actions>
                    <x-button variant="ghost" size="sm">Lihat semua</x-button>
                </x-slot:actions>

                <x-table :headers="['Pengguna', 'Aktivitas', 'Waktu', 'Status']">
                    @php
                        $rows = [
                            ['Budi Santoso', 'Membuat pesanan baru', '2 menit yang lalu', 'Berhasil', 'green'],
                            ['Siti Rahma', 'Memperbarui profil', '18 menit yang lalu', 'Berhasil', 'green'],
                            ['Andi Wijaya', 'Pembayaran tertunda', '1 jam yang lalu', 'Menunggu', 'amber'],
                            ['Dewi Lestari', 'Membatalkan pesanan', '3 jam yang lalu', 'Dibatalkan', 'red'],
                            ['Rizky Pratama', 'Mendaftar akun', 'Kemarin', 'Berhasil', 'green'],
                        ];
                        $badgeColor = [
                            'green' => 'bg-green-50 text-green-700',
                            'amber' => 'bg-amber-50 text-amber-700',
                            'red' => 'bg-red-50 text-red-700',
                        ];
                    @endphp

                    @foreach ($rows as [$name, $activity, $time, $status, $color])
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-avatar :name="$name" size="sm" />
                                    <span class="font-medium text-slate-900">{{ $name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $activity }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $time }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $badgeColor[$color] }}">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        {{-- Summary bar chart (pure SVG) --}}
        <div>
            <x-card title="Ringkasan" subtitle="Pendapatan per bulan">
                @php
                    $chart = [
                        ['Jan', 45], ['Feb', 62], ['Mar', 58],
                        ['Apr', 74], ['Mei', 68], ['Jun', 92],
                    ];
                    $max = max(array_column($chart, 1));
                    $barWidth = 32;
                    $gap = 16;
                    $chartHeight = 160;
                    $svgWidth = count($chart) * ($barWidth + $gap);
                @endphp

                <svg viewBox="0 0 {{ $svgWidth }} {{ $chartHeight + 28 }}" class="h-52 w-full" role="img" aria-label="Grafik pendapatan per bulan">
                    @foreach ($chart as $i => [$label, $value])
                        @php
                            $barHeight = (int) round(($value / $max) * $chartHeight);
                            $x = $i * ($barWidth + $gap) + $gap / 2;
                            $y = $chartHeight - $barHeight;
                        @endphp
                        <rect
                            x="{{ $x }}"
                            y="{{ $y }}"
                            width="{{ $barWidth }}"
                            height="{{ $barHeight }}"
                            rx="6"
                            class="fill-brand-500"
                        />
                        <text
                            x="{{ $x + $barWidth / 2 }}"
                            y="{{ $chartHeight + 18 }}"
                            text-anchor="middle"
                            class="fill-slate-400 text-[10px]"
                        >{{ $label }}</text>
                    @endforeach
                </svg>

                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4 text-sm">
                    <span class="text-slate-500">Total kuartal</span>
                    <span class="font-semibold text-slate-900">Rp 152.400.000</span>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.dashboard>
