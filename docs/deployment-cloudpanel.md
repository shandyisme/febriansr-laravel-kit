# Deployment — CloudPanel & RunCloud

Panduan deploy Febrian Laravel Kit (dan project turunannya) di CloudPanel atau
RunCloud. Stack server: PHP 8.4 (PHP-FPM), MySQL/MariaDB, Nginx.

> **Document root wajib `public/`** (bukan root project).

## 1. Buat Site & Database

**CloudPanel** / **RunCloud:**

1. Buat site PHP baru (PHP 8.4). Set **docroot** ke folder `public/` dari project.
2. Buat database MySQL + user, catat nama DB, user, dan password.
3. Arahkan domain / subdomain ke site tersebut, pasang SSL (Let's Encrypt).

## 2. Ambil Kode

```bash
# di direktori site (mis. /home/<siteuser>/htdocs/<domain>)
git clone <repo-url> .
# atau untuk update rilis berikutnya:
git pull origin main
```

## 3. Dependency & Environment

```bash
composer install --no-dev --optimize-autoloader

cp .env.example .env
# edit .env — isi minimal:
#   APP_NAME, APP_ENV=production, APP_DEBUG=false, APP_URL=https://domain
#   DB_DATABASE, DB_USERNAME, DB_PASSWORD
#   BRAND_* (opsional, untuk rebranding)
#   WA_AI_BASE_URL, WA_AI_API_KEY, WA_PROVIDER (kosongkan → mode simulasi WhatsApp)
#   QUEUE_CONNECTION=database

php artisan key:generate
```

## 4. Database

```bash
php artisan migrate --force

# Region (opsional — kalau modul region dipakai):
php artisan region:import   # muat dump RajaOngkir ke tabel
php artisan region:build    # bangun data region siap pakai
```

## 5. Build Frontend

```bash
npm ci && npm run build
```

## 6. Storage Link

```bash
php artisan storage:link
```

## 7. Cache Produksi

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> Setiap kali `.env` atau config berubah, ulangi `config:cache`. Setiap kali route
> berubah, ulangi `route:cache`.

## 8. Permission Folder

`storage/` dan `bootstrap/cache/` harus writable oleh user PHP-FPM (user site).

```bash
chown -R <siteuser>:<siteuser> storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

> Di CloudPanel/RunCloud, `<siteuser>` adalah user milik site tersebut. Kalau file
> di-clone/di-generate sebagai root, wajib `chown` ulang agar app bisa membaca.

## 9. Queue Worker via Supervisor

Queue memakai **database driver** dan diproses worker permanen lewat **supervisor**.

Buat `/etc/supervisor/conf.d/<app>-worker.conf`:

```ini
[program:<app>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/<siteuser>/htdocs/<domain>/artisan queue:work --sleep=3 --tries=3 --max-time=3600
directory=/home/<siteuser>/htdocs/<domain>
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=<siteuser>
numprocs=1
redirect_stderr=true
stdout_logfile=/home/<siteuser>/htdocs/<domain>/storage/logs/worker.log
stopwaitsecs=3600
```

Terapkan:

```bash
supervisorctl reread
supervisorctl update
supervisorctl start <app>-worker:*
```

> `user` harus user site (bukan root) agar file yang dibuat worker punya ownership
> benar. Setelah deploy kode baru, restart worker: `supervisorctl restart <app>-worker:*`.

## 10. Scheduler via Cron

Scheduler butuh **satu** cron entry (menjalankan seluruh jadwal di
`routes/console.php`, termasuk `kit:cleanup` harian pukul 02:00).

```cron
* * * * * cd /home/<siteuser>/htdocs/<domain> && php artisan schedule:run >> /dev/null 2>&1
```

Pasang lewat crontab user site: `crontab -u <siteuser> -e` (atau menu Cron Job di
CloudPanel/RunCloud).

## Ringkasan Urutan Deploy

```bash
git clone <repo-url> .            # atau git pull
composer install --no-dev --optimize-autoloader
cp .env.example .env              # isi APP_KEY, DB, BRAND_*, WA_AI_*
php artisan key:generate
php artisan migrate --force
php artisan region:import && php artisan region:build   # bila dipakai
npm ci && npm run build
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
chown -R <siteuser>:<siteuser> storage bootstrap/cache
# + supervisor worker + cron scheduler (langkah 9 & 10)
```

## Deploy Ulang (Rilis Berikutnya)

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci && npm run build
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan storage:link            # bila belum ada
supervisorctl restart <app>-worker:*
```
