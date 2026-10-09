<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        return [
            'kode_kategori' => fake()->unique()->bothify('KTG-####'),
            'nama_kategori' => fake()->unique()->words(2, true),
        ];
    }
}
