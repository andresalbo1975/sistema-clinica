<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos a la recepcionista si no existe
        User::firstOrCreate(
            ['email' => 'recepcion@clinica.com'],
            [
                'name' => 'Recepcionista Principal',
                'password' => Hash::make('secreto123') // Hash encripta la contraseña
            ]
        );
    }
}