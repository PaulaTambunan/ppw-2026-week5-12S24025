# SIPUS-Del

Sistem Informasi Perpustakaan Kampus Del untuk mengelola kategori, koleksi buku, serta sirkulasi peminjaman dan pengembalian. Proyek ini melanjutkan SIPUS-Del Minggu 5 dengan konektivitas basis data, transaksi ACID, Query Builder, dan sesi autentikasi pustakawan sesuai Modul Praktikum Minggu 6.

## Kebutuhan

- PHP 8.3 atau lebih baru dengan ekstensi PDO SQLite
- Composer
- Node.js dan NPM jika akan membangun aset frontend

Proyek menggunakan Laravel 13 sesuai kerangka proyek yang tersedia. Modul menyebut Laravel 11; implementasi mengikuti versi Laravel proyek tanpa menurunkan versi framework.

## Menjalankan aplikasi

1. Pasang dependensi:

   ```bash
   composer install
   ```

2. Siapkan `.env` dan kunci aplikasi hanya jika berkas lokal belum tersedia. Jangan menimpa konfigurasi lokal:

   ```powershell
   if (!(Test-Path .env)) {
       Copy-Item .env.example .env
       php artisan key:generate
   }
   ```

3. Pastikan `DB_CONNECTION=sqlite` dan `SESSION_DRIVER=database` pada `.env`. Buat file database SQLite bila belum ada:

   ```powershell
   if (!(Test-Path database\database.sqlite)) { New-Item -ItemType File database\database.sqlite }
   ```

4. Jalankan migrasi dan data contoh:

   ```bash
   php artisan migrate --seed
   ```

5. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`.

## Akun pustakawan uji

- Email: `pustakawan@del.ac.id`
- Kata sandi: `password123`

Seeder juga membuat contoh buku dengan stok 0 dan stok 1, serta satu transaksi peminjaman aktif. Jalankan `php artisan migrate:fresh --seed` hanya pada database lokal yang boleh dihapus.

## Fitur Minggu 6

- Tabel `peminjamans` menyimpan kode pinjam, buku, NIM dan nama peminjam, tanggal pinjam/jatuh tempo/kembali, serta status. Foreign key buku memakai `cascadeOnDelete`.
- Model `Buku` memiliki banyak `Peminjaman`; setiap `Peminjaman` memiliki satu `Buku`.
- Pustakawan dapat mencatat peminjaman. Perubahan stok dan pencatatan pinjam berjalan dalam `DB::transaction()` dengan `lockForUpdate()`. Stok habis dan peminjaman aktif ganda untuk NIM dan buku yang sama ditolak.
- Pengembalian mengunci data peminjaman dan buku, mengubah status, mengisi tanggal kembali, dan menambah stok dalam satu transaksi.
- Kesalahan query dicatat ke log Laravel.
- Katalog menggunakan pencarian judul/penulis/ISBN, filter kategori, `when()`, `withCount('peminjamans')`, dan paginasi yang mempertahankan query pencarian.
- Statistik katalog memakai `DB::table()` untuk total judul, total stok, peminjaman aktif, dan peminjaman yang sudah dikembalikan.
- Pengunjung dapat melihat katalog. Login diperlukan untuk menambah, mengubah, dan menghapus buku/kategori, serta mengelola peminjaman.
- Login menggunakan `Auth::attempt()` dan regenerasi ID sesi. Logout mengakhiri sesi serta meregenerasi token CSRF. Cookie email login `sipus_last_user_email` ditambahkan dengan `Cookie::queue()`; cookie HTTP-only dan SameSite=Lax.
- Riwayat pencarian terakhir dan NIM peminjam terakhir disimpan dalam sesi.

Relasi data utama:

```text
kategoris (1) --- (banyak) bukus (1) --- (banyak) peminjamans
```

## Pengujian

```bash
php artisan test
```

Tes fitur mencakup pencarian/statistik, proteksi login, login/logout, peminjaman dan pengembalian, penolakan saat stok habis, pencegahan peminjaman aktif ganda, serta seeder.

## Bukti pengujian dan cookie

Jalankan aplikasi, lalu login dengan akun uji di atas. Ambil dan simpan screenshot untuk dilampirkan saat pengumpulan:

1. Peminjaman berhasil dan stok buku berkurang.
2. Pengembalian berhasil dan stok buku bertambah.
3. Peminjaman buku dengan stok 0 ditolak.
4. Browser DevTools → Application/Storage → Cookies: tunjukkan cookie `sipus_last_user_email` dengan atribut `HttpOnly`.

Untuk demonstrasi konkurensi row-level locking, gunakan MySQL 8 dengan tabel InnoDB. Konfigurasi SQLite bawaan tetap dapat dipakai untuk menjalankan aplikasi dan tes fitur.

## Pengumpulan

- Branch tugas: `week6-db-session`.
- Jangan commit `.env` atau `vendor/`.
- Gunakan Conventional Commits, misalnya:

  ```text
  feat(migration): create peminjamans table
  feat(transaction): add atomic book borrowing and return
  feat(query-builder): add catalog filters and library statistics
  feat(auth-session): add librarian login and session management
  ```
