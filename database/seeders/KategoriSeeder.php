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
        ])->map(fn (array $kategori) => Kategori::firstOrCreate(
            ['kode_kategori' => $kategori['kode_kategori']],
            ['nama_kategori' => $kategori['nama_kategori']],
        ));

        Buku::factory()
            ->count(20)
            ->recycle($kategoris)
            ->create();
    }
}
