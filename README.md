# SIPUS-Del

Sistem Informasi Perpustakaan Kampus Del untuk mengelola data kategori dan koleksi buku. Aplikasi menerapkan arsitektur MVC Laravel, relasi Eloquent, validasi server-side, Blade components, pagination, serta eager loading untuk menghindari N+1 query.

## Kebutuhan

- PHP 8.3 atau lebih baru dengan ekstensi PDO SQLite
- Composer
- Node.js dan NPM (hanya jika akan membangun aset frontend)

Proyek ini menggunakan Laravel 13 sesuai kerangka aplikasi yang tersedia. Instruksi modul menyebut Laravel 11; implementasi memakai API yang kompatibel dengan struktur proyek saat ini tanpa menurunkan versi framework.

## Menjalankan aplikasi

1. Pasang dependensi PHP:

   ```bash
   composer install
   ```

2. Siapkan konfigurasi lokal. Buat `.env` dari contoh hanya jika belum tersedia; jangan timpa konfigurasi lokal yang sudah ada. `.env` tidak boleh di-commit:

   ```bash
   cp .env.example .env  # jalankan hanya bila .env belum ada
   php artisan key:generate
   ```

   Pada PowerShell, gunakan `Copy-Item .env.example .env` hanya bila `.env` belum ada.

3. Pastikan `DB_CONNECTION=sqlite` pada `.env`, lalu buat file database bila belum ada:

   ```bash
   if (!(Test-Path database/database.sqlite)) { New-Item -ItemType File database/database.sqlite }
   ```

   Di macOS/Linux, gunakan `touch database/database.sqlite`.

4. Jalankan migrasi dan isi data contoh:

   ```bash
   php artisan migrate --seed
   ```

   Seeder membuat 5 kategori dan 20 buku menggunakan factories/Faker. `migrate:fresh --seed` juga tersedia untuk database lokal yang boleh dihapus; perintah itu menghapus seluruh tabel dan data lebih dahulu.

5. Jalankan server:

   ```bash
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`.

## Fitur

- CRUD RESTful untuk buku dan kategori melalui `Route::resource`.
- Route model binding, validasi ISBN unik, judul minimal 5 karakter, stok non-negatif, kategori yang valid, dan validasi atribut lainnya.
- Relasi `Kategori hasMany Buku` dan `Buku belongsTo Kategori`.
- `$fillable` untuk mencegah mass assignment atribut yang tidak diizinkan.
- Eager loading kategori pada daftar buku dan daftar buku per kategori, dengan pagination 10 data per halaman.
- Form Blade memakai `@csrf`, method spoofing untuk PUT/DELETE, output escaped, pesan sukses/kesalahan, serta tampilan responsif bertema Del Purple (`#4C1D95`).
- Penghapusan kategori ditolak selama masih memiliki buku agar data terkait tidak hilang.

## Migrasi, seeding, dan uji

```bash
php artisan migrate
php artisan db:seed
php artisan test
```

Tes fitur memeriksa alur CRUD, validasi, seed data, dan jumlah query eager loading. Pengujian terakhir harus menghasilkan tepat dua SELECT untuk pengambilan daftar buku beserta kategorinya: satu SELECT untuk `bukus`, dan satu SELECT untuk `kategoris`.

## Audit SQL

`AppServiceProvider` memasang listener `DB::listen` pada lingkungan lokal dan mencatat SQL beserta durasi ke log Laravel. Setelah menjalankan aplikasi dan membuka daftar buku, periksa:

```text
storage/logs/laravel.log
```

Cari baris berawalan `[SQL AUDIT]`. Pengambilan koleksi di index menggunakan `Buku::with('kategori')`; bukti terukur dua SELECT juga diuji oleh `test_eager_loading_categories_uses_two_select_queries`.

## Pengumpulan

Pastikan `.env` dan `vendor/` tidak dimasukkan ke repositori; keduanya telah dikecualikan di `.gitignore`. Format nama repositori pada modul adalah `ppw-2026-week5-[NIM]`. Ganti `[NIM]` dengan NIM sebelum membuat repositori dan mengumpulkan tugas.

Gunakan Conventional Commits untuk riwayat perubahan, misalnya:

```text
feat(migration): create kategoris and bukus tables schema
feat(model): define book and category relationships
feat(controller): implement CRUD actions and server validation
feat(views): build responsive Blade catalog and forms
perf(eager-loading): optimize category queries to prevent N+1
```
