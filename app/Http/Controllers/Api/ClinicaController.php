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
    // 1. Listar Pacientes para el select
    public function obtenerPacientes()
    {
        return response()->json(Paciente::all());
    }

    // 2. Listar Médicos para el select
    public function obtenerMedicos()
    {
        return response()->json(Medico::all());
    }

    // 3. Guardar una nueva cita
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
            return response()->json(['error' => 'Error al agendar: ' . $e->getMessage()], 500);
        }
    }

    // 4. NUEVO: Listar todas las citas con sus relaciones (Paciente y Médico)
    public function listarCitas()
    {
        try {
            // Eager Loading: Traemos la cita + nombre del paciente + nombre/especialidad del médico
            $citas = Cita::with([
                'paciente:id,nombre', 
                'medico:id,nombre,especialidad'
            ])
            ->orderBy('fecha_hora', 'desc')
            ->get();

            return response()->json($citas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener listado: ' . $e->getMessage()], 500);
        }
    }
}