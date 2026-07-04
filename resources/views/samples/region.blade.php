<x-layouts.dashboard title="Alamat / Region" :breadcrumbs="[['label' => 'Contoh'], ['label' => 'Region']]">
    <div class="mx-auto max-w-2xl space-y-6">
        <x-card title="Autocomplete Alamat" subtitle="Satu field — cari gabungan kelurahan, kecamatan, kota, dan provinsi.">
            <form action="#" method="POST" class="space-y-4">
                @csrf

                <x-region-select
                    name="region_id"
                    label="Cari Wilayah"
                    placeholder='Ketik minimal 3 huruf, mis. "menteng jakarta"'
                    hint="Data 82.691 kelurahan (RajaOngkir). Setiap kata dicocokkan — makin spesifik makin sempit."
                />

                <div class="flex flex-wrap gap-2 pt-1">
                    <span class="text-xs text-slate-400">Coba:</span>
                    @foreach (['menteng jakarta pusat', 'kuta bali', 'gubeng surabaya', 'coblong bandung'] as $ex)
                        <x-badge variant="gray">{{ $ex }}</x-badge>
                    @endforeach
                </div>

                <div class="flex justify-end border-t border-slate-200/60 pt-4">
                    <x-button type="submit">Simpan Alamat</x-button>
                </div>
            </form>
        </x-card>

        <x-card title="Cara pakai" subtitle="Komponen reusable">
            <pre class="overflow-x-auto rounded-xl bg-slate-900 p-4 text-xs text-slate-100"><code>&lt;x-region-select name="region_id" label="Alamat" /&gt;</code></pre>
            <p class="mt-3 text-sm text-slate-500">
                Menyimpan <code class="rounded bg-slate-100 px-1">region_id</code> (id tabel <code class="rounded bg-slate-100 px-1">regions</code>) di hidden input.
                Endpoint pencarian: <code class="rounded bg-slate-100 px-1">GET /regions/search?q=</code>.
            </p>
        </x-card>
    </div>
</x-layouts.dashboard>
