<?php

namespace Database\Factories;

use App\Models\Kos;
use App\Models\Penghuni;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penghuni>
 */
class PenghuniFactory extends Factory
{
    protected $model = Penghuni::class;

    public function definition(): array
    {
        $tanggalMasuk = fake()->dateTimeBetween('-1 year', 'today');

        return [
            'kos_id' => Kos::factory()->state(['status' => 'active']),
            'jenis_identitas' => fake()->randomElement(['KTP', 'SIM']),
            'nomor_identitas' => fake()->numerify('################'),
            'nama_lengkap' => fake()->name(),
            'pekerjaan' => fake()->jobTitle(),
            'tanggal_masuk' => $tanggalMasuk->format('Y-m-d'),
            'tanggal_keluar' => null,
            'status' => 'active',
            'keterangan' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            $masuk = $attributes['tanggal_masuk'];
            $keluar = fake()->dateTimeBetween($masuk, 'today');

            return [
                'tanggal_keluar' => $keluar->format('Y-m-d'),
                'status' => 'inactive',
                'keterangan' => fake()->sentence(),
            ];
        });
    }
}
