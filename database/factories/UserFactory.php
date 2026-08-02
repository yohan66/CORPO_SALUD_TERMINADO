<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'cedula' => fake()->unique()->numerify('V-########'),
            'password' => static::$password ??= Hash::make('password'),
            'rol' => fake()->randomElement(['admin_patrimonio', 'auditor', 'directivo']),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function adminPatrimonio(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'admin_patrimonio',
            'cedula' => 'V-12345678',
        ]);
    }

    public function auditor(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'auditor',
            'cedula' => 'V-87654321',
        ]);
    }

    public function directivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'rol' => 'directivo',
            'cedula' => 'V-11223344',
        ]);
    }
}
