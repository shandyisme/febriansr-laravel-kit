# Arsitektur — Febrian Laravel Kit

Dokumen ini menjelaskan filosofi, struktur, dan pola arsitektur boilerplate ini.
Baca bersama `AGENTS.md` (aturan pengembangan) dan `README.md` (ringkasan).

## Filosofi

- **Monolith Laravel**, bukan microservice. Satu aplikasi, satu database, mudah dideploy.
- **Ringan & cepat dikembangkan.** Tidak memakai Filament / Jetstream / Inertia /
  admin panel generator. Blade + Livewire + Alpine + Tailwind.
- **Service Layer Pattern.** Business logic terpusat di `app/Services` (atau
  `app/Actions`), controller tetap tipis.
- **Tidak over-engineering.** Solusi paling sederhana yang benar. Utamakan bawaan
  Laravel; jangan menambah package tanpa alasan jelas.
- **Mobile-first & production-ready.** Cocok untuk tim kecil, mudah di-clone jadi
  project baru, dan siap deploy di CloudPanel / RunCloud.

## Stack

| Lapisan     | Teknologi |
|-------------|-----------|
| Framework   | Laravel 13, PHP 8.4+ |
| Frontend    | Livewire 4, Alpine.js (di-bundle via Vite di `resources/js/app.js`) |
| Styling     | TailwindCSS v4 (`@tailwindcss/vite`), Vite |
| Database    | MySQL / MariaDB (default); SQLite untuk demo lokal |
| View        | Blade + komponen reusable (`<x-...>`) |
| Queue       | Database queue (worker via supervisor di server) |

## Struktur `app/`

```
app/
  Actions/          # Aksi tunggal / single-purpose (opsional)
  Console/Commands/ # Artisan commands: region:build, region:import, kit:cleanup
  Enums/            # Enum PHP (status, tipe, dsb)
  Helpers/          # helpers.php → fungsi global: brand(), setting(), setting_set()
  Http/
    Controllers/    # TIPIS — request → authorization → response saja
    Middleware/     # EnsureUserHasRole, EnsureUserHasPermission
  Jobs/             # Job antrean: SendWhatsAppMessageJob
  Models/           # Eloquent model
  Notifications/    # DemoNotification + Channels/WhatsAppChannel
  Providers/        # AppServiceProvider
  Services/         # BUSINESS LOGIC utama (lihat daftar di bawah)
  Support/          # Helper class stateless (formatter, ApiResponse, dll)
  Traits/           # HasRoles, LogsActivity
  View/Components/   # Class-based Blade component (bila perlu)
```

Peran tiap folder:

- **Actions / Services** — tempat business logic. Services untuk logika yang lebih
  besar/berkelanjutan; Actions untuk satu aksi diskrit.
- **Support** — helper class yang stateless dan reusable (format uang, tanggal,
  telepon, response API). Tidak menyimpan state, mudah dipakai di mana saja.
- **Traits** — perilaku reusable yang di-attach ke model (RBAC, activity log).
- **Helpers/helpers.php** — fungsi global level aplikasi (`brand()`, `setting()`,
  `setting_set()`).
- **Http/Controllers** — sengaja tipis. Hanya validasi/authorize, panggil service,
  kembalikan response/view.
- **Console/Commands** — perintah CLI & tugas terjadwal.

## Service Layer Pattern

Controller **hanya** menangani: request → authorization → response. Semua logika
bisnis ada di service/action.

```php
// Controller — TIPIS
class WhatsAppController extends Controller
{
    public function send(Request $request, WhatsAppService $wa)
    {
        $data = $request->validate([
            'phone'   => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $wa->send($data['phone'], $data['message']); // logic di service

        return back()->with('flash', 'Pesan diantrikan.');
    }
}
```

```php
// Service — business logic
class WhatsAppService
{
    public function send(string $phone, string $message): WhatsappMessageLog
    {
        $phone = PhoneNormalizer::toE164($phone);
        // ...buat log, dispatch job ke queue, dsb.
    }
}
```

Aturannya: kalau ada logika lebih dari sekadar meneruskan data, pindahkan ke
service. Controller tidak boleh gemuk.

## Brand / Design Token System

Sumber kebenaran tunggal branding ada di **`config/brand.php`** dan diakses lewat
helper **`brand()`**.

Cara kerja:

1. `config/brand.php` mendefinisikan `app_name`, logo, favicon, dan **skala warna
   lengkap** (`brand` = primary/oranye, `accent` = secondary/biru-cyan).
2. Saat runtime, `resources/views/components/brand-styles.blade.php` menyuntikkan
   skala warna itu sebagai **CSS custom properties**, meng-override default
   `@theme` Tailwind v4.
3. Karena itu utilitas seperti `bg-brand-500`, `text-accent-600`, `border-brand-200`
   otomatis berubah warna ketika config diubah.

Aturan mutlak:

- **JANGAN hardcode warna hex** di komponen/Blade/CSS. Selalu pakai token
  `brand-*` / `accent-*` / `slate-*` + warna status (green/red/amber untuk
  success/error/warning).
- **Rebranding cukup ubah `config/brand.php`** (atau `BRAND_*` di `.env`) —
  komponen dan layout tidak perlu disentuh.

Nilai bisa di-override lewat `.env`: `APP_NAME`, `BRAND_LOGO_TEXT`,
`BRAND_LOGO_PATH`, `BRAND_FAVICON`, `BRAND_PRIMARY_COLOR`, `BRAND_SECONDARY_COLOR`,
`BRAND_ACCENT_COLOR`.

## Modul & Service Utama

| Modul          | Komponen inti |
|----------------|---------------|
| **Auth**       | Hand-rolled: login/logout, forgot/reset password, profil, ganti password. Registrasi opsional (`AUTH_REGISTRATION_ENABLED`). |
| **RBAC**       | Model `Role`/`Permission` + pivot, trait `HasRoles`, middleware `role`/`permission`. |
| **Settings**   | Tabel `settings` + model `Setting`, helper `setting()` / `setting_set()`. |
| **Activity Log** | `Services/ActivityLogger` + trait `LogsActivity`, model `ActivityLog`. |
| **Media**      | `Services/MediaService` (upload/replace/delete) + model `MediaFile`, disk `local` (mudah pindah S3/DO Spaces via `FileUploadHelper`). |
| **Region**     | Model `Region` + `<x-region-select>` autocomplete. Data dari dump RajaOngkir (`database/data/rajaongkir-region.sql.gz`) via `region:import` lalu `region:build`. |
| **WhatsApp**   | `Services/WhatsApp/WaAiClient` + `WhatsAppService` (send/sendOtp/sendNotification/sendReminder), `SendWhatsAppMessageJob` (queue, tries=3, backoff), model `WhatsappMessageLog`. Mode **simulasi** bila `WA_AI_*` kosong. |
| **Import/Export** | `Services/Export/{SpreadsheetExporter,PdfExporter}` (CSV/XLSX/PDF), `Services/Import/SpreadsheetImporter`. |
| **Notifications** | `DemoNotification` + `Notifications/Channels/WhatsAppChannel` (database + in-app + WhatsApp), bell di topbar. |

Support classes (`app/Support/`): `ApiResponse`, `MoneyFormatter`, `DateFormatter`,
`PhoneNormalizer`, `IndonesianFormatter`, `WhatsAppFormatter`, `FileUploadHelper`.

## Component Library

Komponen Blade di `resources/views/components/` (dipakai lewat `<x-...>`):

- **Form & input:** `input`, `textarea`, `select`, `multi-select`, `toggle`,
  `date-picker`, `date-range-picker`, `region-select`, `image-upload`
  (drag + preview).
- **Layout & struktur:** `card`, `table`, `pagination`, `tabs`, `breadcrumbs`,
  `timeline`, `empty-state`, `skeleton`.
- **Feedback & status:** `alert`, `badge`, `flash`, `toast` (`window.toast()`),
  `stat-card`.
- **Overlay & aksi:** `button`, `modal`, `dropdown`, `drawer`, `slide-over`,
  `avatar`.
- **Data & visual:** `chart` (Chart.js, di-bundle via Vite).
- **Branding (internal):** `brand-head`, `brand-styles` (inject CSS var warna).
- **Layout utama:** `layouts/public`, `layouts/auth`, `layouts/dashboard`.
- **Partials:** `partials/sidebar`, `partials/notifications-bell`.

> Catatan runtime: layout **wajib** memuat `@livewireStyles` (head) +
> `@livewireScripts` (body) agar runtime Livewire/Alpine ter-load — kalau tidak,
> `x-show` (dropdown/drawer) tidak berfungsi.

## Data Layer

- **RBAC** — tabel `roles`, `permissions`, `role_user`, `permission_role`. Trait
  `HasRoles` di `User`: `hasRole()`, `hasPermission()`, `canAccess()`,
  `assignRole()`. Middleware alias `role` & `permission` didaftarkan di
  `bootstrap/app.php`. Seeder `RolePermissionSeeder` (peran: admin, manajer, staf).
- **Settings** — key/value di tabel `settings`, diakses lewat `setting($key)` dan
  `setting_set($key, $value)`.
- **Activity Log** — `activity_logs`; dicatat lewat trait `LogsActivity` pada model
  atau langsung via `ActivityLogger`.
- **Media** — `media_files` (metadata file), dikelola `MediaService`.
- **Region** — tabel `regions`, diisi dari dump RajaOngkir.
- **WhatsApp logs** — `whatsapp_message_logs`, mencatat SEMUA request & response.
- **Notifications** — tabel notifications bawaan Laravel (database channel) +
  channel WhatsApp custom.

## Scheduler & Queue

- **Queue:** database queue. Di server live dijalankan oleh worker supervisor.
- **Scheduler:** `routes/console.php` memuat
  `Schedule::command('kit:cleanup')->dailyAt('02:00')` (prune log & notifikasi
  lama). Butuh satu cron: `* * * * * php artisan schedule:run`.

Detail deploy queue worker & cron ada di `docs/deployment-cloudpanel.md`.
