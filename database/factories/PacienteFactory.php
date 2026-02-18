<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            // fake() genera datos aleatorios pero con sentido lógico
            'nombre' => fake()->name(),
            'rut_dni' => fake()->unique()->numerify('########-#'),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('+56 9 #### ####'),
            'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
        ];
    }
}