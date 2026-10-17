<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;

class SipusTahapDuaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pustakawan@del.ac.id'],
            ['name' => 'Pustakawan', 'password' => 'password123'],
        );

        $kategori = Kategori::where('kode_kategori', 'KOM-001')->firstOrFail();

        Buku::firstOrCreate(
            ['isbn' => '9786020000101'],
            [
                'judul' => 'Contoh Buku Tanpa Stok',
                'penulis' => 'Tim SIPUS-Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => (int) date('Y'),
                'kategori_id' => $kategori->id,
                'stok' => 0,
            ],
        );

        Buku::firstOrCreate(
            ['isbn' => '9786020000102'],
            [
                'judul' => 'Contoh Buku Stok Satu',
                'penulis' => 'Tim SIPUS-Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => (int) date('Y'),
                'kategori_id' => $kategori->id,
                'stok' => 1,
            ],
        );

        $bukuTransaksi = Buku::firstOrCreate(
            ['isbn' => '9786020000103'],
            [
                'judul' => 'Contoh Buku dengan Riwayat Peminjaman',
                'penulis' => 'Tim SIPUS-Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => (int) date('Y'),
                'kategori_id' => $kategori->id,
                'stok' => 5,
            ],
        );

        $peminjaman = Peminjaman::firstOrCreate(
            ['kode_pinjam' => 'PJM-SEED-001'],
            [
                'buku_id' => $bukuTransaksi->id,
                'nim_peminjam' => '12S24001',
                'nama_peminjam' => 'Mahasiswa Contoh',
                'tanggal_pinjam' => today(),
                'tanggal_jatuh_tempo' => today()->addDays(14),
                'status' => 'dipinjam',
            ],
        );

        if ($peminjaman->wasRecentlyCreated) {
            $bukuTransaksi->decrement('stok');
        }
    }
}
