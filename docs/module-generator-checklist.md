# Checklist Module Baru

Standar minimal setiap module baru (dari `AGENTS.md`). Ikuti berurutan. Contoh di
bawah memakai module fiktif **Member**.

## Standar Minimal per Module

Setiap module minimal punya:

- Migration
- Model
- Service (business logic)
- Policy (authorization)
- Request Validation (FormRequest bila app cukup besar)
- Blade Page
- Livewire Component (bila interaktif)
- Activity Log (untuk perubahan penting)
- Import — opsional
- Export — opsional

## Langkah Berurutan

### 1. Migration + Model

- [ ] `php artisan make:model Member -mf`
      (`-m` migration, `-f` factory untuk test)
- [ ] Isi kolom di migration (snake_case), lalu `php artisan migrate`.
- [ ] Set `$fillable` / cast di model.

### 2. Service

- [ ] Buat `app/Services/MemberService.php` — taruh SEMUA business logic di sini.
- [ ] Controller hanya memanggil service (tetap tipis).

```php
class MemberService
{
    public function create(array $data): Member
    {
        return Member::create($data);
    }
}
```

### 3. Policy

- [ ] `php artisan make:policy MemberPolicy --model=Member`
- [ ] Definisikan `viewAny/view/create/update/delete`, integrasikan dengan RBAC
      (`$user->hasPermission('members.view')` / `canAccess()`).
- [ ] Gunakan di controller: `$this->authorize('create', Member::class);`

### 4. Request Validation

- [ ] `php artisan make:request StoreMemberRequest` (dan `UpdateMemberRequest`)
- [ ] Isi `rules()`. Untuk validasi kecil boleh inline `$request->validate()`,
      tapi form besar → FormRequest.

### 5. Controller (Tipis)

- [ ] `php artisan make:controller MemberController`
- [ ] Hanya: request → authorize → panggil service → response.

### 6. Blade Page

- [ ] Buat view di `resources/views/members/` memakai `layouts/dashboard`.
- [ ] **Pakai komponen `<x-...>`** (card, table, button, input, badge,
      empty-state, pagination, modal, dll) — jangan markup styling acak.
- [ ] **Pakai token warna** `brand-*` / `accent-*` — jangan hardcode hex.
- [ ] Rancang **mobile-first**.

### 7. Livewire Component (bila interaktif)

- [ ] `php artisan make:livewire Members/MemberTable`
      (untuk list/filter/search real-time, form dinamis, dsb).
- [ ] Pastikan layout memuat `@livewireStyles` + `@livewireScripts`.

### 8. Activity Log

- [ ] Untuk perubahan penting, pakai trait `LogsActivity` di model **atau**
      panggil `ActivityLogger` di service (catat create/update/delete).

### 9. Import / Export (opsional)

- [ ] Export: pakai `Services/Export/SpreadsheetExporter` (CSV/XLSX) atau
      `PdfExporter` (PDF). Tambahkan dropdown export di data table.
- [ ] Import: pakai `Services/Import/SpreadsheetImporter` + halaman upload dengan
      preview.

### 10. Route + Navigasi

- [ ] Daftarkan route di `routes/web.php` (kebab-case, dalam grup `auth`,
      + middleware `permission:` bila perlu).
- [ ] Tambahkan menu di `resources/views/components/partials/sidebar.blade.php`.

### 11. Feature Test

- [ ] `php artisan make:test MemberTest`
- [ ] Uji alur penting: akses (RBAC 403 vs 200), create, update, delete.

## Sebelum Commit

- [ ] `vendor/bin/pint` (format kode).
- [ ] `php artisan test` (hijau).
- [ ] Commit message jelas. Jangan commit `.env`, `vendor/`, `node_modules/`.
