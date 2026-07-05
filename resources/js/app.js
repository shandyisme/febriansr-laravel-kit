import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Single-field region autocomplete (see <x-region-select>).
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
            const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(q), { headers: { Accept: 'application/json' } });
            this.results = await res.json();
            this.open = true;
        } catch (e) { this.results = []; } finally { this.loading = false; }
    },
    choose(r) { this.query = r.label; this.selectedId = r.id; this.results = []; this.open = false; },
    clear() { this.query = ''; this.selectedId = ''; this.results = []; this.open = false; },
}));

// Drag-and-drop image upload with thumbnail preview (see <x-image-upload>).
Alpine.data('imageUpload', (existingUrl = '') => ({
    preview: existingUrl || '',
    fileName: '',
    fileSize: '',
    dragging: false,
    onDrop(e) {
        this.dragging = false;
        const files = e.dataTransfer?.files;
        if (files && files.length) { this.$refs.input.files = files; this.set(files[0]); }
    },
    onPick(e) {
        const file = e.target.files?.[0];
        if (file) this.set(file);
    },
    set(file) {
        if (!file || !file.type.startsWith('image/')) return;
        if (this.preview && this.preview.startsWith('blob:')) URL.revokeObjectURL(this.preview);
        this.preview = URL.createObjectURL(file);
        this.fileName = file.name;
        this.fileSize = this.human(file.size);
    },
    clear() {
        if (this.preview && this.preview.startsWith('blob:')) URL.revokeObjectURL(this.preview);
        this.preview = ''; this.fileName = ''; this.fileSize = '';
        this.$refs.input.value = '';
    },
    human(b) {
        if (!b) return '';
        const u = ['B', 'KB', 'MB', 'GB']; const i = Math.floor(Math.log(b) / Math.log(1024));
        return (b / Math.pow(1024, i)).toFixed(i ? 1 : 0) + ' ' + u[i];
    },
}));

Livewire.start();
