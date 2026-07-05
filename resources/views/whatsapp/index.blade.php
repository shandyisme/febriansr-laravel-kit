@php
    use Illuminate\Support\Str;

    $statusMap = [
        'sent' => ['variant' => 'green', 'label' => 'Terkirim'],
        'pending' => ['variant' => 'amber', 'label' => 'Menunggu'],
        'failed' => ['variant' => 'red', 'label' => 'Gagal'],
    ];
@endphp

<x-layouts.dashboard title="WhatsApp" :breadcrumbs="[['label' => 'Modul'], ['label' => 'WhatsApp']]">
    <div class="space-y-6">
        <x-alert variant="info" title="Mode Simulasi">
            Mode simulasi aktif jika <code class="font-mono">WA_AI_BASE_URL</code>/<code class="font-mono">WA_AI_API_KEY</code>
            belum diisi — pesan tetap diantrikan &amp; dicatat.
        </x-alert>

        <x-card title="Kirim Pesan Uji">
            <form method="POST" action="{{ route('whatsapp.send') }}" class="space-y-4">
                @csrf

                <x-input
                    name="to"
                    label="Nomor Tujuan"
                    placeholder="08123456789"
                    hint="Otomatis dinormalisasi ke 62…"
                />

                <x-select
                    name="type"
                    label="Jenis"
                    :options="['message' => 'Pesan', 'otp' => 'OTP', 'notification' => 'Notifikasi', 'reminder' => 'Pengingat']"
                />

                <x-textarea
                    name="message"
                    label="Pesan"
                    hint="Kosongkan untuk pesan default / diabaikan untuk OTP"
                >{{ old('message') }}</x-textarea>

                <div>
                    <x-button type="submit">Kirim</x-button>
                </div>
            </form>
        </x-card>

        <x-card title="Log Pesan" :padding="''">
            @if ($logs->isEmpty())
                <x-empty-state title="Belum ada pesan" description="Pesan yang dikirim akan tercatat di sini." />
            @else
                <x-table :headers="['Waktu', 'Tujuan', 'Jenis', 'Pesan', 'Status']">
                    @foreach ($logs as $log)
                        @php
                            $status = $statusMap[$log->status] ?? ['variant' => 'gray', 'label' => $log->status];
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-500">
                                {{ \App\Support\DateFormatter::withTime($log->created_at) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">{{ $log->to }}</td>
                            <td class="px-4 py-3"><x-badge variant="accent">{{ $log->type }}</x-badge></td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ Str::limit($log->message, 50) }}</td>
                            <td class="px-4 py-3">
                                <x-badge :variant="$status['variant']">{{ $status['label'] }}</x-badge>
                            </td>
                        </tr>
                    @endforeach
                </x-table>

                <div class="border-t border-slate-100 p-4">
                    <x-pagination :paginator="$logs" />
                </div>
            @endif
        </x-card>
    </div>
</x-layouts.dashboard>
