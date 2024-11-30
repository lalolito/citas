<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Citas;
use App\Http\Controllers\Controller;


class citasController extends Controller
{
    public function index()
    {
        try {
            $citas = Citas::all();
            return response()->json($citas, 200);
        } catch (\Exception $e) {
            \Log::error('Error al obtener las citas: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al procesar la solicitud.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $cita = Citas::find($id);

            if (!$cita) {
                return response()->json(['message' => 'Cita no encontrada'], 404);
            }

            return response()->json($cita, 200);
        } catch (\Exception $e) {
            \Log::error('Error al obtener la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al procesar la solicitud.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validación de los datos
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string|max:50',
                'tipo_documento' => 'required|in:cc,ti,cxe,pasaporte',
                'numero_documento' => 'required|string|max:20|unique:citas',
                'tipo_servicio' => 'required|in:cambio de aceite,revision general,mantenimiento general',
                'dia' => 'required|date',
                'hora' => 'required|date_format:H:i',
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'El apellido es obligatorio.',
                'tipo_documento.required' => 'El tipo de documento es obligatorio.',
                'tipo_documento.in' => 'El tipo de documento no es válido.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'numero_documento.unique' => 'El número de documento ya está registrado.',
                'tipo_servicio.required' => 'El tipo de servicio es obligatorio.',
                'tipo_servicio.in' => 'El tipo de servicio no es válido.',
                'dia.required' => 'El día de la cita es obligatorio.',
                'dia.date' => 'El día debe ser una fecha válida.',
                'hora.required' => 'La hora de la cita es obligatoria.',
                'hora.date_format' => 'La hora debe tener el formato HH:mm.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Creación de la cita
            $cita = Citas::create($validator->validated());
            return response()->json($cita, 201);

        } catch (\Exception $e) {
            \Log::error('Error al guardar la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al procesar la solicitud.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cita = Citas::find($id);

            if (!$cita) {
                return response()->json(['message' => 'Cita no encontrada'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre' => 'nullable|string|max:50',
                'apellido' => 'nullable|string|max:50',
                'tipo_documento' => 'nullable|in:cc,ti,cxe,pasaporte',
                'numero_documento' => 'nullable|string|max:20|unique:citas,numero_documento,' . $id,
                'tipo_servicio' => 'nullable|in:cambio de aceite,revision general,mantenimiento general',
                'dia' => 'nullable|date',
                'hora' => 'nullable|date_format:H:i',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $cita->update($validator->validated());
            return response()->json($cita, 200);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al procesar la solicitud.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cita = Citas::find($id);

            if (!$cita) {
                return response()->json(['message' => 'Cita no encontrada'], 404);
            }

            $cita->delete();
            return response()->json(['message' => 'Cita eliminada exitosamente'], 200);

        } catch (\Exception $e) {
            \Log::error('Error al eliminar la cita: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al procesar la solicitud.'], 500);
        }
    }
}

