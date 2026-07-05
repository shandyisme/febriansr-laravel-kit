{{-- Toast host — place once per layout. Trigger anywhere with:
     window.toast('Pesan', 'success'|'error'|'info'|'warning')
     or in Blade: onclick="window.toast('Tersimpan')" --}}
<div
    x-data="{
        toasts: [],
        add(e) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, message: e.detail.message, type: e.detail.type || 'success' });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) { this.toasts = this.toasts.filter(t => t.id !== id); },
        ring(t) { return { success: 'text-green-600', error: 'text-red-600', warning: 'text-amber-600', info: 'text-accent-600' }[t.type] || 'text-slate-600'; },
    }"
    @toast.window="add($event)"
    class="pointer-events-none fixed inset-x-0 top-4 z-[60] flex flex-col items-center gap-2 px-4 sm:items-end sm:pr-6">
    <template x-for="t in toasts" :key="t.id">
        <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0"
            class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-xl bg-white/90 px-4 py-3 shadow-lg ring-1 ring-slate-900/5 backdrop-blur-xl">
            <svg :class="ring(t)" class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.9" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            <span class="flex-1 text-sm text-slate-700" x-text="t.message"></span>
            <button type="button" @click="remove(t.id)" class="text-slate-400 hover:text-slate-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </template>
</div>
