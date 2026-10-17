<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_pinjam' => fake()->unique()->bothify('PJM-########'),
            'buku_id' => Buku::factory(),
            'nim_peminjam' => fake()->numerify('12######'),
            'nama_peminjam' => fake()->name(),
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_jatuh_tempo' => now()->addDays(14)->toDateString(),
            'tanggal_kembali' => null,
            'status' => 'dipinjam',
        ];
    }
}
