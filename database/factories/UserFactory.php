<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= 'password',
            'remember_token' => Str::random(10),
            'role' => 'pemilik_kos',
            'wilayah_id' => null,
            'status' => 'active',
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role' => 'admin',
            'wilayah_id' => Wilayah::factory(),
        ]);
    }

    public function superAdmin(): static
    {
        return $this->state([
            'role' => 'super_admin',
            'wilayah_id' => null,
        ]);
    }

    public function pemilikKos(): static
    {
        return $this->state([
            'role' => 'pemilik_kos',
            'wilayah_id' => null,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => 'inactive',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
