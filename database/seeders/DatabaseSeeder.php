<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use App\Models\Medico;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Le pedimos a las fábricas que creen 50 pacientes y 10 médicos
        Paciente::factory(50)->create();
        Medico::factory(10)->create();
    }
}