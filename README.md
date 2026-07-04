# Febrian Laravel Kit

Boilerplate Laravel reusable — standar utama seluruh proyek Laravel milik Febrian.
Monolith, ringan, cepat dikembangkan, production-ready, CloudPanel & RunCloud friendly.

Dipakai untuk: Pratidina, Finance App, dashboard operasional, internal tools, mini SaaS,
CRM sederhana, aplikasi komunitas/perumahan, aplikasi bisnis keluarga, dll.

## Tech Stack

- **Laravel 13** · **PHP 8.4+**
- **Livewire 4** · **Alpine.js**
- **TailwindCSS v4** (`@tailwindcss/vite`) · **Vite**
- MySQL / MariaDB (default) — SQLite untuk demo lokal
- Blade + komponen reusable

Tidak memakai: Filament, Jetstream, Inertia, admin panel generator.

## Yang sudah ada (Fase 1 — Fondasi)

- **Brand token system** — `config/brand.php` + helper `brand()`. Rebranding cukup ubah config/env, tanpa menyentuh komponen. Warna via token (`brand-*`, `accent-*`), tidak ada hardcode.
- **3 Layout** — `public`, `auth`, `dashboard` (sidebar responsif, topbar, breadcrumb, page title, action buttons, mobile nav).
- **Auth hand-roll** — login, logout, forgot/reset password, profil, ganti password, middleware `auth`. Registrasi opsional (`AUTH_REGISTRATION_ENABLED`).
- **~16 Komponen Blade** — Button, Card, StatCard, Badge, Alert, Input, Textarea, Select, Table, Pagination, Modal, Dropdown, EmptyState, Avatar, Breadcrumbs, Flash, Sidebar.
- **Support classes** (`app/Support/`) — ApiResponse, MoneyFormatter, DateFormatter, PhoneNormalizer, IndonesianFormatter, WhatsAppFormatter, FileUploadHelper.
- **Arsitektur** — `app/{Actions,Services,Support,Enums,Traits,Helpers,View/Components}` (Service Layer Pattern).
- **Contoh** — halaman Dashboard, Profil, Settings, landing publik.
- **Quality** — Laravel Pint + feature test (login, akses dashboard).

## Roadmap (fase berikutnya)

- **Fase 2** — RBAC (roles/permissions), Activity Log, tabel `settings`/`media_files`, Media System.
- **Fase 3** — Modul WhatsApp (WA AI: WaAiClient, WhatsAppService, SendWhatsAppMessageJob, log, OTP/notif/reminder).
- **Fase 4** — Import/Export (CSV/XLSX/PDF), Notification system, sisa komponen (Toast, Tabs, Drawer, Slide Over, Timeline, Chart Wrapper, Date Picker, Multi Select, File Upload, Skeleton).
- **Fase 5** — Scheduler siap pakai, dokumentasi lengkap (`docs/`), deploy checklist.

## Membuat project baru

```bash
git clone git@github.com:shandyisme/febriansr-laravel-kit.git nama-project
cd nama-project
composer install
cp .env.example .env
php artisan key:generate
# atur DB di .env, lalu:
php artisan migrate
npm install && npm run build
php artisan storage:link
```

Rebranding untuk klien: ubah `config/brand.php` (atau `BRAND_*` di `.env`).

## Development

```bash
composer run dev      # atau: php artisan serve + npm run dev
vendor/bin/pint       # format kode
php artisan test      # jalankan test
```

## Deployment (CloudPanel / RunCloud)

- Document root: `public/`
- PHP 8.4, MySQL/MariaDB
- Setelah deploy: `composer install --no-dev -o`, `npm ci && npm run build`, `php artisan migrate --force`, `php artisan storage:link`, cache config/route/view.
- Queue worker & scheduler menyusul di Fase 3–5.

Lihat `AGENTS.md` untuk aturan pengembangan.
