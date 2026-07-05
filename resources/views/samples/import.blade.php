<x-layouts.dashboard title="Impor Data" :breadcrumbs="[['label' => 'Contoh'], ['label' => 'Impor']]">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Unggah Berkas" subtitle="Impor data anggota dari berkas CSV atau Excel.">
                <form method="POST" action="{{ route('samples.import.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="file" class="mb-1.5 block text-sm font-medium text-slate-700">Berkas Spreadsheet</label>
                        <input
                            type="file"
                            name="file"
                            id="file"
                            accept=".csv,.xlsx"
                            class="block w-full rounded-xl text-sm text-slate-600 ring-1 ring-inset ring-slate-300 file:mr-4 file:border-0 file:bg-brand-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-500"
                        >
                        @error('file')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-slate-400">Format didukung: .csv, .xlsx — maksimal 500 baris data.</p>
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit">Impor Data</x-button>
                    </div>
                </form>
            </x-card>

            @if (session('imported'))
                @php
                    $imported = session('imported');
                    $preview = array_slice($imported, 0, 10);
                    $columns = ! empty($preview) ? array_keys($preview[0]) : [];
                @endphp

                <x-card :padding="''">
                    <div class="flex items-center justify-between border-b border-slate-100 p-4">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">Pratinjau Hasil Impor</h3>
                            <p class="mt-0.5 text-xs text-slate-500">{{ count($imported) }} baris terbaca — menampilkan {{ count($preview) }} baris pertama.</p>
                        </div>
                        <x-badge variant="green">{{ count($imported) }} baris</x-badge>
                    </div>

                    @if (empty($preview))
                        <x-empty-state title="Tidak ada data" description="Berkas tidak berisi baris data yang dapat dibaca." />
                    @else
                        <x-table :headers="$columns">
                            @foreach ($preview as $row)
                                <tr class="hover:bg-slate-50">
                                    @foreach ($columns as $col)
                                        <td class="px-4 py-3 text-slate-700">{{ $row[$col] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </x-table>
                    @endif
                </x-card>
            @endif
        </div>

        <div class="space-y-6">
            <x-alert variant="info" title="Format yang Didukung">
                <ul class="mt-1 list-inside list-disc space-y-1">
                    <li>CSV (.csv) — dipisah koma, UTF-8.</li>
                    <li>Excel (.xlsx) — sheet pertama yang dibaca.</li>
                </ul>
                <p class="mt-2">Baris pertama diperlakukan sebagai <strong>header kolom</strong>. Maksimal 500 baris data diproses demi keamanan.</p>
            </x-alert>
        </div>
    </div>
</x-layouts.dashboard>
