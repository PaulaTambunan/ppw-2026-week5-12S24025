<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = collect([
            ['kode_kategori' => 'FIK-001', 'nama_kategori' => 'Fiksi'],
            ['kode_kategori' => 'KOM-001', 'nama_kategori' => 'Komputer'],
            ['kode_kategori' => 'SAI-001', 'nama_kategori' => 'Sains'],
            ['kode_kategori' => 'BIS-001', 'nama_kategori' => 'Bisnis'],
            ['kode_kategori' => 'SEJ-001', 'nama_kategori' => 'Sejarah'],
        ])->mapWithKeys(fn (array $kategori) => [
            $kategori['kode_kategori'] => Kategori::firstOrCreate(
                ['kode_kategori' => $kategori['kode_kategori']],
                ['nama_kategori' => $kategori['nama_kategori']],
            ),
        ]);

        $bukuContoh = [
            ['9786020000001', 'Pemrograman Web dengan Laravel', 'KOM-001'],
            ['9786020000002', 'Algoritma dan Struktur Data', 'KOM-001'],
            ['9786020000003', 'Dasar-Dasar Basis Data Relasional', 'KOM-001'],
            ['9786020000004', 'Jaringan Komputer: Konsep dan Praktik', 'KOM-001'],
            ['9786020000005', 'Kecerdasan Buatan untuk Pemula', 'KOM-001'],
            ['9786020000006', 'Analisis dan Perancangan Sistem Informasi', 'KOM-001'],
            ['9786020000007', 'Pengembangan Aplikasi Berbasis Web', 'KOM-001'],
            ['9786020000008', 'Rekayasa Perangkat Lunak', 'KOM-001'],
            ['9786020000009', 'Pengantar Sains Data', 'SAI-001'],
            ['9786020000010', 'Matematika Diskret untuk Informatika', 'SAI-001'],
            ['9786020000011', 'Pengantar Statistika Terapan', 'SAI-001'],
            ['9786020000012', 'Visualisasi Data dengan Python', 'SAI-001'],
            ['9786020000013', 'Strategi Bisnis Digital', 'BIS-001'],
            ['9786020000014', 'Inovasi dan Kewirausahaan', 'BIS-001'],
            ['9786020000015', 'Dasar-Dasar Manajemen Modern', 'BIS-001'],
            ['9786020000016', 'Kepemimpinan dalam Organisasi', 'BIS-001'],
            ['9786020000017', 'Pengantar Ilmu Sejarah', 'SEJ-001'],
            ['9786020000018', 'Sejarah Perkembangan Teknologi', 'SEJ-001'],
            ['9786020000019', 'Filsafat Ilmu Pengetahuan', 'SEJ-001'],
            ['9786020000020', 'Teknik Menulis Karya Ilmiah', 'SEJ-001'],
        ];

        foreach ($bukuContoh as [$isbn, $judul, $kodeKategori]) {
            Buku::updateOrCreate(
                ['isbn' => $isbn],
                [
                    'judul' => $judul,
                    'penulis' => fake('id_ID')->name(),
                    'penerbit' => fake('id_ID')->company(),
                    'tahun_terbit' => fake()->numberBetween(2018, (int) date('Y')),
                    'kategori_id' => $kategoris[$kodeKategori]->id,
                    'stok' => fake()->numberBetween(0, 50),
                    'sinopsis' => "Buku ini membahas {$judul} secara bertahap, dilengkapi konsep dasar dan contoh penerapan.",
                ],
            );
        }
    }
}
