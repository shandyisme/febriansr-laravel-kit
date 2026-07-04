# AGENTS.md — Febrian Laravel Kit

Aturan pengembangan untuk boilerplate ini dan seluruh project turunannya.
Baca sebelum menulis kode.

## Filosofi

Monolith Laravel yang ringan, cepat dikembangkan, tidak over-engineering, mudah
di-maintain, dan mudah di-clone jadi project baru. Bukan microservice. Mobile-first.
Production-ready. Cocok untuk tim kecil.

## Aturan wajib

1. **Service Layer Pattern.** Business logic di `app/Services` (atau `app/Actions`).
   Controller hanya: request → authorization → response. Jangan menaruh business
   logic berat di controller.
2. **Komponen Blade reusable.** Gunakan `<x-...>` yang sudah ada; jangan menulis
   markup styling acak. Komponen reusable baru → `resources/views/components/`.
3. **Token warna brand.** Selalu `brand-*` / `accent-*` / `slate-*` + warna status.
   **JANGAN hardcode warna hex.** Rebranding harus cukup lewat `config/brand.php`.
4. **Mobile-first.** Rancang untuk layar kecil dulu, lalu `sm: md: lg:`.
5. **Tailwind UI sebagai referensi** visual & UX (lisensi Tailwind UI Plus). Komponen
   reusable dikonversi menjadi Blade Component. Jangan styling acak.
6. **Hindari over-engineering.** Solusi paling sederhana yang benar.
7. **Jangan menambah package tanpa alasan jelas.** Utamakan bawaan Laravel.
8. **Naming convention konsisten** (StudlyCase class, camelCase method, kebab-case
   Blade component & route, snake_case kolom DB).
9. Credential di `.env`, bukan hardcoded. Response API konsisten (`App\Support\ApiResponse`).

## Struktur `app/`

```
app/
  Actions/          # aksi tunggal (opsional)
  Services/         # business logic
  Support/          # helper class (Money/Date/Phone/Indonesian/WhatsApp/File/ApiResponse)
  Enums/
  Traits/
  Helpers/          # helper functions global (helpers.php → brand(), dll)
  View/Components/   # class-based blade components bila perlu
  Http/Controllers/  # tipis
```

## Design System

- Primary: **orange** (`brand-*`). Secondary/chart/info: **biru/cyan** (`accent-*`).
- Karakter: modern, clean, premium, ringan — bukan admin panel generik.
- `rounded-xl` / `rounded-2xl`, shadow lembut, spacing lega, glassmorphism tipis &
  gradient halus bila cocok.
- Semua layout membaca branding via `brand()` / `config/brand.php`.

## Standar Module Baru

Setiap module baru minimal punya:

- Migration
- Model
- Service
- Policy
- Request Validation (FormRequest bila app cukup besar)
- Blade Page
- Livewire Component (bila interaktif)
- Activity Log (untuk perubahan penting)
- Import — opsional
- Export — opsional

## Alur kerja

- `vendor/bin/pint` sebelum commit.
- Tambahkan feature test untuk alur penting.
- Jangan commit `.env`, credential, `vendor/`, `node_modules/`.
- Commit message jelas.
