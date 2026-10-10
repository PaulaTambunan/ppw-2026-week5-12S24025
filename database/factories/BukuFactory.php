<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition(): array
    {
        $judul = fake('id_ID')->randomElement([
            'Algoritma dan Struktur Data',
            'Analisis dan Perancangan Sistem Informasi',
            'Belajar Pemrograman Python',
            'Berpikir Kritis di Era Digital',
            'Dasar-Dasar Basis Data Relasional',
            'Dasar-Dasar Ekonomi Mikro',
            'Dasar-Dasar Manajemen Modern',
            'Etika dan Tanggung Jawab Digital',
            'Filsafat Ilmu Pengetahuan',
            'Inovasi dan Kewirausahaan',
            'Jaringan Komputer: Konsep dan Praktik',
            'Kecerdasan Buatan untuk Pemula',
            'Kepemimpinan dalam Organisasi',
            'Manajemen Proyek Teknologi Informasi',
            'Matematika Diskret untuk Informatika',
            'Pengantar Analisis Data',
            'Pengantar Ilmu Sejarah',
            'Pengantar Statistika Terapan',
            'Pemrograman Web dengan Laravel',
            'Pengembangan Aplikasi Berbasis Web',
            'Pengantar Sistem Informasi',
            'Rekayasa Perangkat Lunak',
            'Sains Data untuk Pemula',
            'Sistem Operasi Modern',
            'Strategi Bisnis Digital',
            'Teknik Menulis Karya Ilmiah',
            'Teori dan Praktik Akuntansi',
            'UI dan UX untuk Aplikasi Digital',
            'Visualisasi Data dengan Python',
            'Ekonomi Kreatif dan Industri Digital',
        ]);

        return [
            'isbn' => fake('id_ID')->unique()->numerify('978602#######'),
            'judul' => $judul,
            'penulis' => fake('id_ID')->name(),
            'penerbit' => fake('id_ID')->company(),
            'tahun_terbit' => fake()->numberBetween(1990, (int) date('Y')),
            'kategori_id' => Kategori::factory(),
            'stok' => fake()->numberBetween(0, 50),
            'sinopsis' => "Buku ini membahas {$judul} secara bertahap, mulai dari konsep dasar hingga contoh penerapannya.",
        ];
    }
}
