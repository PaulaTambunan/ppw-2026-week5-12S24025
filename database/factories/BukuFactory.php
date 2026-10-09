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
        return [
            'isbn' => fake()->unique()->numerify('978##########'),
            'judul' => fake()->unique()->sentence(4),
            'penulis' => fake()->name(),
            'penerbit' => fake()->company(),
            'tahun_terbit' => fake()->numberBetween(1990, (int) date('Y')),
            'kategori_id' => Kategori::factory(),
            'stok' => fake()->numberBetween(0, 50),
            'sinopsis' => fake()->paragraph(),
        ];
    }
}
