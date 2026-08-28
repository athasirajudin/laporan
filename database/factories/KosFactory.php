<?php

namespace Database\Factories;

use App\Models\Kos;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kos>
 */
class KosFactory extends Factory
{
    protected $model = Kos::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'pemilik_kos']),
            'wilayah_id' => Wilayah::factory(),
            'nama_kos' => 'Kos '.fake()->lastName(),
            'alamat' => fake()->address(),
            'status' => 'pending',
        ];
    }
}
