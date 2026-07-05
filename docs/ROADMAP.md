# Febrian Laravel Kit — Roadmap & Progress

Status pengerjaan boilerplate. Update setiap fase selesai. Titik lanjut kalau sesi terputus.

## Konteks singkat

- **Repo:** git@github.com:shandyisme/febriansr-laravel-kit.git (branch `main`)
- **Lokasi/demo:** `/home/febriansr-kit/htdocs/kit.febriansr.id` → https://kit.febriansr.id
  (CloudPanel, docroot `public/`, PHP-FPM 8.4). Login demo: `demo@kit.test` / `password123`.
- **Stack:** Laravel 13 · Livewire 4 · Tailwind v4 (`@tailwindcss/vite`) · Alpine · Vite · PHP 8.4.
- **DB:** sqlite lokal (demo); `.env.example` default MySQL untuk project clone.
- **Push:** deploy key di `/home/febriansr-kit/.ssh/id_ed25519`. Jalankan git sbg `su - febriansr-kit`.

## Catatan teknis penting (jangan terulang)

- Layout **wajib** `@livewireStyles` (head) + `@livewireScripts` (body). JANGAN `@livewireScriptConfig`
  saja — itu tidak me-load runtime Livewire/Alpine → `x-show` tak jalan (dropdown/drawer tak bisa ditutup).
- `[x-cloak]{display:none}` ada di `resources/css/app.css`.
- Warna: token `brand-*`/`accent-*` (via `config/brand.php` + `resources/views/components/brand-styles.blade.php`
  yang inject CSS var). JANGAN hardcode hex. Rebrand = ubah config saja.
- File dibuat sbg root (mis. via subagent) harus `chown -R febriansr-kit:febriansr-kit` sebelum app baca.
- Setelah ubah Blade/CSS: `npm run build` (kalau ada class baru) + `php artisan view:clear`.
- Tidak ada headless browser di server → interaksi Alpine tak bisa diklik-tes; verifikasi di browser asli.
- Domain di belakang Cloudflare (email di HTML jadi "[email protected]" — normal).

## Selesai

- **Fase 1 — Fondasi** (commit `4388da9`): brand token system, 3 layout (public/auth/dashboard),
  auth hand-roll (login/logout/forgot/reset/profil/ganti password, `AUTH_REGISTRATION_ENABLED`),
  ~16 komponen Blade, 7 Support classes, arsitektur `app/` (Service Layer), contoh dashboard/profil/settings,
  Pint + 7 feature test, README + AGENTS.md.
- **Follow-up** (commit `60b8184`): fix runtime Alpine/Livewire; komponen `x-toggle` & `x-tabs`;
  halaman sample `/samples/{table,form,components}` (SampleController) + menu sidebar.
- **Fase 2 — RBAC + Activity Log + Settings + Media** (selesai 2026-07-05): tabel & model
  roles/permissions/pivot + trait `HasRoles` (hasRole/hasPermission/canAccess/assignRole) + middleware
  `role`/`permission` (alias di bootstrap/app.php) + seeder (admin/manajer/staf, 7 permission, demo=admin).
  Activity Log (`ActivityLogger` + trait `LogsActivity`). Settings (`setting()`/`setting_set()`).
  Media System (`media_files` + `MediaService`: upload/replace/delete). Halaman `/access/{roles,activity}`
  (gated permission) + menu sidebar. RbacTest (403 vs 200). 10 test pass total.

## Backlog — kerjakan berurutan

### Fase 5 — Scheduler + Docs lengkap — BERIKUTNYA
- [ ] Scheduler siap pakai (reminder, report generation, cleanup) di `routes/console.php`.
- [ ] Docs: `architecture.md`, `development-rules.md`, `deployment-cloudpanel.md`,
      `new-project-checklist.md`, `module-generator-checklist.md`.
- [ ] Deploy checklist (queue worker supervisor, scheduler cron, storage link, permission).

### Fase 4 — SELESAI ✅
- **4a** (commit b66f068): Import/Export (openspout CSV/XLSX + dompdf PDF: SpreadsheetExporter/
  PdfExporter/SpreadsheetImporter + ExportController, export dropdown di data table, halaman impor
  dengan preview). Notification system (database + in-app + WhatsApp channel; DemoNotification,
  NotificationController, halaman notifikasi, bell di topbar).
- **4b** (commit d5002aa): komponen Toast (+window.toast), Drawer, Slide Over, Timeline, Multi Select,
  Loading Skeleton, Chart (Chart.js bundled), Date Picker & Date Range Picker (flatpickr bundled).
  Didemokan di tab "Lanjutan" halaman Komponen.

### Fase 3 — Modul WhatsApp — SELESAI ✅
`config/whatsapp.php`; `whatsapp_message_logs`; `WaAiClient` (mode simulasi jika WA_AI_* kosong);
`WhatsAppService` (send/sendOtp/sendNotification/sendReminder → antri + log); `SendWhatsAppMessageJob`
(queue, tries=3, backoff, catat request/response); halaman `/whatsapp` (kirim uji + log). **Queue worker
supervisor `kit-febriansr-worker`** memproses antrean (di server ini). WhatsAppTest hijau.

### Fase 2 — SELESAI ✅ (lihat daftar di atas)
- [ ] Migration + model: `roles`, `permissions`, `role_user`, `permission_role`.
- [ ] Trait/helper di User: `hasRole()`, `hasPermission()`, `canAccess()`.
- [ ] Middleware `role` dan `permission` (daftarkan alias di `bootstrap/app.php`).
- [ ] Seeder role/permission default (admin, staf, dst).
- [ ] Tabel + model `activity_logs`; helper/observer untuk catat create/update/delete/login/upload.
- [ ] Tabel + model `settings` (key/value) + helper `setting()`.
- [ ] Tabel + model `media_files`; Media System (upload gambar/dokumen, preview, delete, replace, metadata;
      disk `local`, mudah pindah S3/DO Spaces via `FileUploadHelper`).
- [ ] Halaman contoh: manajemen role/permission + daftar activity log.
- [ ] Test: middleware role/permission menolak/mengizinkan.

### Fase 3 — Modul WhatsApp (WA AI)
- [ ] `config/whatsapp.php` (base_url, api_key, provider). Env `WA_AI_BASE_URL`/`WA_AI_API_KEY`/`WA_PROVIDER=wa_ai`.
- [ ] `App\Services\WhatsApp\WaAiClient` (HTTP client ke WA AI Febrian) + `WhatsAppService` (send message/OTP/notif/reminder).
- [ ] `SendWhatsAppMessageJob` (queue, retry). Model `WhatsappMessageLog` + migration.
- [ ] Log SEMUA request & response. Contoh kirim OTP + notifikasi.
- [ ] Test: service log tersimpan; job dispatch.

### Fase 4 — Import/Export + Notifikasi + sisa komponen
- [ ] Import CSV/XLSX, Export CSV/XLSX/PDF (pilih paket: openspout/maatwebsite + dompdf; hindari over-eng).
- [ ] Notification system: database + in-app + WhatsApp channel.
- [ ] Komponen sisa: Toast, Drawer, Slide Over, Timeline, Chart Wrapper, Date Picker, Date Range Picker,
      Multi Select, File Upload, Loading Skeleton. (Toggle & Tabs sudah ada.)

### Fase 5 — Scheduler + Docs lengkap
- [ ] Scheduler siap pakai (reminder, report generation, cleanup) di `routes/console.php`.
- [ ] Docs: `docs/architecture.md`, `development-rules.md`, `deployment-cloudpanel.md`,
      `new-project-checklist.md`, `module-generator-checklist.md`.
- [ ] Deploy checklist (queue worker via supervisor, scheduler cron, storage link, permission).

## Standar module baru (dari AGENTS.md)
Migration · Model · Service · Policy · Request Validation · Blade Page · Livewire Component ·
Activity Log · Import (opsional) · Export (opsional).
