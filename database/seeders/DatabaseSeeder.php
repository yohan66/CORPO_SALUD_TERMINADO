<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->adminPatrimonio()->create([
            'nombre' => 'María González',
            'email' => 'admin@corpossalud.gob.ve',
            'cedula' => 'V-12345678',
        ]);

        User::factory()->auditor()->create([
            'nombre' => 'Carlos Ramírez',
            'email' => 'auditor@corpossalud.gob.ve',
            'cedula' => 'V-87654321',
        ]);

        User::factory()->directivo()->create([
            'nombre' => 'Ana Martínez',
            'email' => 'directivo@corpossalud.gob.ve',
            'cedula' => 'V-11223344',
        ]);
    }
}
