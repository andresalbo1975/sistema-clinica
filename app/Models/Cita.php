<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = ['paciente_id', 'medico_id', 'fecha_hora', 'estado'];

    // Relación: Una cita pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación: Una cita pertenece a un médico
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}