# Aturan Pengembangan — Febrian Laravel Kit

Perluasan dari `AGENTS.md` dengan contoh konkret. Baca sebelum menulis kode di
boilerplate ini atau project turunannya.

## 1. Service Layer Pattern

Controller **tipis**: request → authorization → response. Business logic di
`app/Services` atau `app/Actions`.

**Salah** (logic berat di controller):

```php
public function store(Request $request)
{
    $data = $request->validate([...]);
    $member = Member::create($data);
    Mail::to($member)->send(new WelcomeMail($member));
    activity()->log('member.created');
    // ...banyak logika lain
    return redirect()->route('members.index');
}
```

**Benar** (logic dipindah ke service):

```php
// Controller
public function store(StoreMemberRequest $request, MemberService $service)
{
    $service->create($request->validated());

    return redirect()->route('members.index')
        ->with('flash', 'Member ditambahkan.');
}

// app/Services/MemberService.php
class MemberService
{
    public function create(array $data): Member
    {
        $member = Member::create($data);
        // kirim notifikasi, catat activity log, dsb.
        return $member;
    }
}
```

## 2. Komponen Blade Reusable

Gunakan komponen `<x-...>` yang sudah ada. Jangan menulis markup styling acak.

**Jangan:**

```blade
<button class="bg-orange-500 text-white px-4 py-2 rounded-lg">Simpan</button>
```

**Pakai komponen:**

```blade
<x-button type="submit">Simpan</x-button>
<x-input name="email" label="Email" type="email" />
<x-card>...</x-card>
```

Kalau butuh pola baru yang reusable, buat komponen di
`resources/views/components/` — jangan copy-paste markup.

## 3. Token Warna Brand

**JANGAN hardcode warna hex.** Selalu token `brand-*` / `accent-*` / `slate-*` +
warna status.

**Jangan:** `style="color:#ff6d01"` atau `class="bg-[#ff6d01]"`
**Benar:** `class="bg-brand-500 text-white"`, `class="text-accent-600"`

Rebranding harus cukup lewat `config/brand.php` (atau `BRAND_*` di `.env`).
Warna di-inject sebagai CSS var oleh `brand-styles.blade.php`.

## 4. Mobile-First

Rancang untuk layar kecil dulu, baru tambahkan breakpoint `sm: md: lg:`.

```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">...</div>
```

## 5. Naming Convention

| Elemen                 | Konvensi     | Contoh |
|------------------------|--------------|--------|
| Class (Model/Service)  | StudlyCase   | `MemberService`, `WhatsappMessageLog` |
| Method / variable      | camelCase    | `sendReminder()`, `$isActive` |
| Blade component & route| kebab-case   | `<x-stat-card>`, `route('members.index')` |
| Kolom database         | snake_case   | `created_at`, `phone_number` |

## 6. Package & Over-Engineering

- **Jangan menambah package tanpa alasan jelas.** Utamakan bawaan Laravel.
- Pilih solusi paling sederhana yang benar. Hindari abstraksi berlebihan.

## 7. Validasi — FormRequest untuk Yang Besar

Validasi kecil boleh inline (`$request->validate([...])`). Untuk form besar atau
aturan kompleks, buat **FormRequest**:

```bash
php artisan make:request StoreMemberRequest
```

```php
class StoreMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
        ];
    }
}
```

## 8. Response API Konsisten

Untuk endpoint API/JSON, gunakan `App\Support\ApiResponse` agar bentuk response
seragam.

```php
return ApiResponse::success($data, 'Berhasil.');
return ApiResponse::error('Gagal.', status: 422);
```

## 9. Credential di `.env`

Jangan hardcode API key / password. Selalu lewat `.env` + `config/`.

## 10. Testing & Pint Sebelum Commit

- Jalankan **`vendor/bin/pint`** sebelum commit (format kode).
- Jalankan **`php artisan test`**; tambahkan feature test untuk alur penting.
- Jangan commit `.env`, credential, `vendor/`, `node_modules/`.
- Commit message jelas.

---

## Do / Don't

**Do**

- [x] Taruh business logic di Service/Action, controller tetap tipis.
- [x] Pakai komponen `<x-...>` yang sudah ada.
- [x] Pakai token warna `brand-*` / `accent-*`.
- [x] Rancang mobile-first, lalu tambahkan breakpoint.
- [x] Pakai FormRequest untuk validasi besar.
- [x] Pakai `ApiResponse` untuk endpoint API.
- [x] Catat perubahan penting via `LogsActivity` / `ActivityLogger`.
- [x] Jalankan Pint + test sebelum commit.

**Don't**

- [ ] Jangan menaruh business logic berat di controller.
- [ ] Jangan menulis markup styling acak / copy-paste.
- [ ] Jangan hardcode warna hex.
- [ ] Jangan menambah package tanpa alasan jelas.
- [ ] Jangan hardcode credential di kode.
- [ ] Jangan commit `.env`, `vendor/`, `node_modules/`.
- [ ] Jangan over-engineering — pilih yang paling sederhana yang benar.
