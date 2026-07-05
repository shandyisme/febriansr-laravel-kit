import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Chart from 'chart.js/auto';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

// Global toast helper: window.toast('Tersimpan', 'success'|'error'|'info'|'warning')
window.toast = (message, type = 'success') =>
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));

// Region autocomplete (see <x-region-select>).
Alpine.data('regionSelect', (searchUrl, initialId = '', initialLabel = '') => ({
    searchUrl, query: initialLabel || '', selectedId: initialId || '', results: [], open: false, loading: false,
    async search() {
        const q = this.query.trim();
        if (q.length < 3) { this.results = []; this.open = false; return; }
        this.loading = true;
        try { const r = await fetch(this.searchUrl + '?q=' + encodeURIComponent(q), { headers: { Accept: 'application/json' } }); this.results = await r.json(); this.open = true; }
        catch (e) { this.results = []; } finally { this.loading = false; }
    },
    choose(r) { this.query = r.label; this.selectedId = r.id; this.results = []; this.open = false; },
    clear() { this.query = ''; this.selectedId = ''; this.results = []; this.open = false; },
}));

// Drag-and-drop image upload (see <x-image-upload>).
Alpine.data('imageUpload', (existingUrl = '') => ({
    preview: existingUrl || '', fileName: '', fileSize: '', dragging: false,
    onDrop(e) { this.dragging = false; const f = e.dataTransfer?.files; if (f && f.length) { this.$refs.input.files = f; this.set(f[0]); } },
    onPick(e) { const f = e.target.files?.[0]; if (f) this.set(f); },
    set(f) { if (!f || !f.type.startsWith('image/')) return; if (this.preview?.startsWith('blob:')) URL.revokeObjectURL(this.preview); this.preview = URL.createObjectURL(f); this.fileName = f.name; this.fileSize = this.human(f.size); },
    clear() { if (this.preview?.startsWith('blob:')) URL.revokeObjectURL(this.preview); this.preview = ''; this.fileName = ''; this.fileSize = ''; this.$refs.input.value = ''; },
    human(b) { if (!b) return ''; const u = ['B', 'KB', 'MB', 'GB']; const i = Math.floor(Math.log(b) / Math.log(1024)); return (b / Math.pow(1024, i)).toFixed(i ? 1 : 0) + ' ' + u[i]; },
}));

// Multi-select with search + chips (see <x-multi-select>).
Alpine.data('multiSelect', (options = [], initial = []) => ({
    options, selected: initial || [], query: '', open: false,
    get filtered() { const q = this.query.toLowerCase(); return this.options.filter(o => !this.selected.includes(o.value) && o.label.toLowerCase().includes(q)); },
    labelFor(v) { return (this.options.find(o => o.value === v) || {}).label || v; },
    add(v) { if (!this.selected.includes(v)) this.selected.push(v); this.query = ''; },
    remove(v) { this.selected = this.selected.filter(x => x !== v); },
}));

// Chart.js wrapper (see <x-chart>).
Alpine.data('chartBox', (config) => ({
    init() { new Chart(this.$refs.canvas, config); },
}));

// flatpickr date / date-range (see <x-date-picker>, <x-date-range-picker>).
Alpine.data('datePicker', (opts = {}) => ({
    init() { flatpickr(this.$refs.input, opts); },
}));

Livewire.start();
