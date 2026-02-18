<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Cita;
use Carbon\Carbon;

class ClinicaController extends Controller
{
    public function obtenerPacientes()
    {
        return response()->json(Paciente::all());
    }

    public function obtenerMedicos()
    {
        return response()->json(Medico::all());
    }

    public function agendar(Request $request)
    {
        try {
            $request->validate([
                'medico_id'   => 'required',
                'paciente_id' => 'required',
                'fecha_hora'  => 'required|date', 
            ]);

            $cita = new Cita();
            $cita->medico_id   = $request->medico_id;
            $cita->paciente_id = $request->paciente_id;
            $cita->fecha_hora  = Carbon::parse($request->fecha_hora);
            $cita->estado      = 'Pendiente';
            $cita->save();

            return response()->json(['mensaje' => '¡Cita guardada en PostgreSQL!'], 201);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }
}