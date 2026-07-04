<x-layouts.dashboard title="Peran &amp; Izin" :breadcrumbs="[['label' => 'Akses'], ['label' => 'Peran']]">
    @if ($roles->isEmpty())
        <x-empty-state title="Belum ada peran" description="Peran akan muncul di sini setelah dibuat." />
    @else
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            @foreach ($roles as $role)
                <x-card :title="$role->label ?? $role->name" :subtitle="$role->name">
                    @if ($role->permissions->isEmpty())
                        <p class="text-sm text-slate-400">Belum ada izin untuk peran ini.</p>
                    @else
                        <div class="flex flex-wrap gap-2">
                            @foreach ($role->permissions as $permission)
                                <x-badge variant="accent">{{ $permission->label ?? $permission->name }}</x-badge>
                            @endforeach
                        </div>
                    @endif
                </x-card>
            @endforeach
        </div>
    @endif
</x-layouts.dashboard>
