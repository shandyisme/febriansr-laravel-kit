import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Reusable single-field region autocomplete (see <x-region-select>).
Alpine.data('regionSelect', (searchUrl, initialId = '', initialLabel = '') => ({
    searchUrl,
    query: initialLabel || '',
    selectedId: initialId || '',
    results: [],
    open: false,
    loading: false,
    async search() {
        const q = this.query.trim();
        if (q.length < 3) { this.results = []; this.open = false; return; }
        this.loading = true;
        try {
            const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(q), {
                headers: { Accept: 'application/json' },
            });
            this.results = await res.json();
            this.open = true;
        } catch (e) {
            this.results = [];
        } finally {
            this.loading = false;
        }
    },
    choose(r) {
        this.query = r.label;
        this.selectedId = r.id;
        this.results = [];
        this.open = false;
    },
    clear() {
        this.query = '';
        this.selectedId = '';
        this.results = [];
        this.open = false;
    },
}));

Livewire.start();
