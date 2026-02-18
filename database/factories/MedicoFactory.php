<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicoFactory extends Factory
{
    public function definition(): array
    {
        // Creamos una lista de especialidades reales
        $especialidades = ['Pediatría', 'Cardiología', 'Dermatología', 'Neurología', 'Medicina General', 'Traumatología'];

        return [
            'nombre' => 'Dr. ' . fake()->lastName(),
            'especialidad' => fake()->randomElement($especialidades),
            'email' => fake()->unique()->companyEmail(),
        ];
    }
}