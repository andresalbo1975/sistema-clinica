<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    // Le decimos qué campos se pueden insertar masivamente
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'fecha_hora',
        'estado'
    ];
}