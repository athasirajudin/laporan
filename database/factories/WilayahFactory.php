<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Wilayah>
 */
class WilayahFactory extends Factory
{
    public function definition(): array
    {
        return [
            'rt' => fake()->numerify('###'),
            'rw' => fake()->numerify('###'),
            'kelurahan' => fake()->citySuffix(),
            'kecamatan' => fake()->citySuffix(),
            'kabupaten_kota' => fake()->city(),
            'provinsi' => fake()->state(),
            'kode_pos' => fake()->postcode(),
        ];
    }
}
