<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habito;
use App\Models\HabitoRegistro;
use Carbon\Carbon;

class HabitoController extends Controller
{
    // 1. Carga la pantalla principal
    public function index()
    {
        $usuarioId = \Auth::id();
        $hoy = now()->toDateString();

        // Trae los hábitos y su progreso de HOY
        $habitos = Habito::with(['registros' => function($query) use ($hoy) {
            $query->where('fecha_registro', $hoy);
        }])
        ->where('usuario_id', $usuarioId)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('habitos', compact('habitos'));
    }

    // 2. Guarda un hábito nuevo desde el modal
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:binario,numerico',
            'meta_numerica' => 'nullable|integer|min:1',
            'unidad' => 'nullable|string|max:50',
            'frecuencia' => 'required|string|in:diario,semanal,mensual' // Nueva validación
        ]);

        Habito::create([
            'usuario_id' => \Auth::id(),
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'meta_numerica' => $request->tipo === 'numerico' ? $request->meta_numerica : null,
            'unidad' => $request->tipo === 'numerico' ? $request->unidad : null,
            'frecuencia' => [$request->frecuencia], // Guardamos si es diario, semanal o mensual
            'fecha_inicio' => now()->timezone('America/Mexico_City')->toDateString(),
        ]);

        return redirect()->route('habitos.index');
    }

    // 3. Actualiza el progreso cuando le picas al "+" o al circulito
    public function registrarProgreso(Request $request, $id)
    {
        $habito = Habito::findOrFail($id);
        $hoy = now()->toDateString();

        $registro = HabitoRegistro::firstOrCreate(
            ['habito_id' => $id, 'fecha_registro' => $hoy],
            ['progreso_actual' => 0, 'completado' => false]
        );

        if ($habito->tipo === 'binario') {
            $registro->completado = !$registro->completado;
            $registro->progreso_actual = $registro->completado ? 1 : 0;
        } else {
            $cambio = $request->cambio; 
            $nuevoProgreso = $registro->progreso_actual + $cambio;

            if ($nuevoProgreso < 0) $nuevoProgreso = 0;
            if ($nuevoProgreso > $habito->meta_numerica) $nuevoProgreso = $habito->meta_numerica;

            $registro->progreso_actual = $nuevoProgreso;
            $registro->completado = ($nuevoProgreso >= $habito->meta_numerica);
        }

        $registro->save();

        return response()->json([
            'success' => true, 
            'progreso_actual' => $registro->progreso_actual,
            'completado' => $registro->completado
        ]);
    }
}