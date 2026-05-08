<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rutina;
use App\Models\RutinaEjercicio;
use App\Models\GrupoMuscular;
use App\Models\Ejercicio;
use Illuminate\Support\Facades\DB;

class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = Auth::user()->rutinas;
        return view('rutinas.index', compact('rutinas'));
    }

    public function crear()
    {
        // Traemos todos los grupos, pero les agregamos el GIF de su primer ejercicio para la cuadrícula
        $grupos = GrupoMuscular::all()->map(function ($grupo) {
            $primerEjercicio = Ejercicio::where('grupo_muscular_id', $grupo->id_grupos_musculares)
                ->whereNotNull('gif_url')
                ->first();

            $grupo->gif_representativo = $primerEjercicio ? $primerEjercicio->gif_url : null;
            return $grupo;
        });

        return view('rutinas.crear', compact('grupos'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'dia_asignado' => 'nullable|string',
            'ejercicios' => 'required|array|min:1',
        ]);

        $rutina = Rutina::create([
            'usuario_id' => Auth::id(),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dia_asignado' => $request->dia_asignado,
        ]);

        foreach ($request->ejercicios as $ejercicio) {
            RutinaEjercicio::create([
                'rutina_id' => $rutina->id_rutinas,
                'ejercicio_id' => $ejercicio['id'],
                'target_sets' => $ejercicio['sets'],
                'target_reps' => $ejercicio['reps'],
                'rest_seconds' => $ejercicio['rest'],
            ]);
        }

        return response()->json(['success' => true, 'mensaje' => 'Rutina guardada correctamente']);
    }

    public function obtenerEjerciciosPorGrupo($id_grupo)
    {
        $ejercicios = Ejercicio::where('grupo_muscular_id', $id_grupo)->get();
        return response()->json($ejercicios);
    }

    public function show($id)
    {
        $rutina = Rutina::with('ejercicios.detalleEjercicio')
            ->where('usuario_id', Auth::id())
            ->findOrFail($id);

        return view('rutinas.show', compact('rutina'));
    }

    public function destroy($id)
    {
        $rutina = Rutina::where('usuario_id', Auth::id())->findOrFail($id);
        $rutina->delete();
        return redirect('/rutinas')->with('mensaje', 'Rutina enviada a la papelera');
    }

    public function edit($id)
    {
        $rutina = Rutina::with('ejercicios.detalleEjercicio')
            ->where('usuario_id', Auth::id())
            ->findOrFail($id);

        // Mapeamos los grupos para que también tengan GIFs en la vista de edición
        $grupos = GrupoMuscular::all()->map(function ($grupo) {
            $primerEjercicio = Ejercicio::where('grupo_muscular_id', $grupo->id_grupos_musculares)
                ->whereNotNull('gif_url')
                ->first();

            $grupo->gif_representativo = $primerEjercicio ? $primerEjercicio->gif_url : null;
            return $grupo;
        });

        return view('rutinas.edit', compact('rutina', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ejercicios' => 'required|array|min:1',
        ]);

        $rutina = Rutina::where('usuario_id', Auth::id())->findOrFail($id);
        
        $rutina->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dia_asignado' => $request->dia_asignado,
        ]);

        // Reemplazamos los ejercicios
        RutinaEjercicio::where('rutina_id', $rutina->id_rutinas)->delete();

        foreach ($request->ejercicios as $ejercicio) {
            RutinaEjercicio::create([
                'rutina_id' => $rutina->id_rutinas,
                'ejercicio_id' => $ejercicio['id'],
                'target_sets' => $ejercicio['sets'],
                'target_reps' => $ejercicio['reps'],
                'rest_seconds' => $ejercicio['rest'],
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function papelera()
    {
        $rutinas = Rutina::onlyTrashed()
            ->where('usuario_id', Auth::id())
            ->get();

        return view('rutinas.papelera', compact('rutinas'));
    }

    public function restaurar($id)
    {
        $rutina = Rutina::onlyTrashed()->where('usuario_id', Auth::id())->findOrFail($id);
        $rutina->restore();
        return redirect('/rutinas')->with('mensaje', 'Rutina restaurada con éxito');
    }

    public function iniciar($id)
    {
        $rutina = Rutina::with('ejercicios.detalleEjercicio')
            ->where('usuario_id', Auth::id())
            ->findOrFail($id);

        if ($rutina->ejercicios->isEmpty()) {
            return redirect('/rutinas/' . $id)->with('error', 'Agrega ejercicios para poder iniciar esta rutina');
        }
        return view('rutinas.iniciar', compact('rutina'));
    }

    public function guardarEntrenamiento(Request $request, $id)
    {
        try {
            // Guardamos la sesión padre
            $sesionId = DB::table('sesiones')->insertGetId([
                'usuario_id' => \Auth::id(), 
                'rutina_id' => $id,
                'duracion_segundos' => $request->tiempo_total,
                'created_at' => now() // <-- Quitamos los updated_at que rompían todo
            ]);

            // Guardamos el detalle de las series
            foreach ($request->historial as $ejercicio) {
                foreach ($ejercicio['series'] as $serie) {
                    DB::table('sesiones_series')->insert([
                        'sesion_id' => $sesionId,
                        'ejercicio_id' => $ejercicio['id_ejercicio'],
                        'reps_objetivo' => $serie['reps_objetivo'],
                        'estado' => $serie['estado'] ?? 'omitida', 
                        'created_at' => now() // <-- Quitamos los updated_at
                    ]);
                }
            }

            return response()->json(['success' => true, 'mensaje' => '¡Entrenamiento guardado con éxito!']);

        } catch (\Exception $e) {
            // Si vuelve a fallar, enviamos el error real al navegador
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}