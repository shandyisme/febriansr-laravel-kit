# Checklist Project Baru dari Kit

Langkah membuat project baru dengan meng-clone Febrian Laravel Kit. Ikuti berurutan.
Detail deploy produksi ada di `docs/deployment-cloudpanel.md`.

## 1. Clone & Setup Repo

- [ ] `git clone <repo-kit> nama-project`
- [ ] `cd nama-project`
- [ ] (Opsional) ganti git remote ke repo project baru:
      `git remote set-url origin <repo-project-baru>`
- [ ] (Opsional) ubah `name` di `composer.json` dan `package.json`.

## 2. Dependency & Environment

- [ ] `composer install`
- [ ] `cp .env.example .env`
- [ ] `php artisan key:generate`

## 3. Database

- [ ] Buat database (MySQL/MariaDB), lalu isi `DB_*` di `.env`.
- [ ] `php artisan migrate`
- [ ] `php artisan db:seed --class=RolePermissionSeeder`
      (buat peran admin/manajer/staf + permission default)
- [ ] (Opsional, bila pakai region) `php artisan region:import` lalu
      `php artisan region:build`.

## 4. Rebranding

- [ ] Ubah `config/brand.php`: `app_name`, `logo_text` / `logo_path`, `favicon`,
      dan skala warna `brand` / `accent`.
      **Atau** set `BRAND_*` di `.env` (`APP_NAME`, `BRAND_LOGO_TEXT`,
      `BRAND_LOGO_PATH`, `BRAND_FAVICON`, `BRAND_PRIMARY_COLOR`,
      `BRAND_SECONDARY_COLOR`, `BRAND_ACCENT_COLOR`).
- [ ] JANGAN hardcode warna hex di komponen — cukup ubah config.

## 5. Frontend

- [ ] `npm install && npm run build`
- [ ] `php artisan storage:link`

## 6. User Admin

- [ ] Buat user admin (lewat tinker atau seeder), lalu beri peran admin:
      `$user->assignRole('admin');`
- [ ] (Kalau tidak pakai seeder demo, pastikan user pertama punya peran admin.)

## 7. Queue & Scheduler (bila perlu)

- [ ] Set `QUEUE_CONNECTION=database` di `.env` (default kit).
- [ ] Siapkan queue worker (lokal: `php artisan queue:work`; produksi: supervisor —
      lihat `docs/deployment-cloudpanel.md`).
- [ ] Pasang cron scheduler:
      `* * * * * cd /path && php artisan schedule:run >> /dev/null 2>&1`
      (menjalankan `kit:cleanup` harian, dst).

## 8. Bersihkan Contoh yang Tak Dipakai

- [ ] Hapus / matikan modul & halaman sample yang tidak dibutuhkan:
      route `samples.*` di `routes/web.php`, `SampleController`, view
      `resources/views/samples/`, dan menu sidebar terkait.
- [ ] Hapus modul contoh yang tak dipakai (mis. WhatsApp, Region, Import/Export)
      bila project tidak memerlukannya — beserta route, controller, view, dan
      menu-nya.
- [ ] Sesuaikan `DemoNotification` / demo data.

## 9. Verifikasi

- [ ] `vendor/bin/pint` (format kode).
- [ ] `php artisan test` (pastikan hijau).
- [ ] Cek login, dashboard (`/dasbor`), dan halaman utama di browser.
