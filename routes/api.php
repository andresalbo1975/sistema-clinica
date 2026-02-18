<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClinicaController;

// Rutas GET para obtener datos
Route::get('/pacientes', [ClinicaController::class, 'obtenerPacientes']);
Route::get('/medicos', [ClinicaController::class, 'obtenerMedicos']);

// Ruta POST para recibir y guardar datos (¡NUEVA!)
Route::post('/citas/agendar', [ClinicaController::class, 'agendar']);
// Ruta para listar las citas
Route::get('/citas', [ClinicaController::class, 'listarCitas']);