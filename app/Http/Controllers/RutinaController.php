<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rutina;
use App\Models\RutinaEjercicio;
use App\Models\GrupoMuscular;
use App\Models\Ejercicio;

class RutinaController extends Controller
{
    public function index(){
        $rutinas = Auth::user()->rutinas;
        return view('rutinas.index',compact('rutinas'));

    }

    public function crear(){
        $grupos = GrupoMuscular::all();
        return view('rutinas.crear',compact('grupos'));

    }

    public function guardar(Request $request){
       $request->validate([
        'nombre'=>'required|string|max:255',
        'dia_asignado'=> 'nullable|string',
        'ejercicios'=>'required|array|min:1',
       ]);

       $rutina = Rutina::create([
        'usuario_id'=>\Auth::id(),
        'nombre'=>$request->nombre,
        'descripcion'=>$request->descripcion,
        'dia_asignado' => $request->dia_asignado,
       ]);
       foreach ($request->ejercicios as $ejercicio){
        RutinaEjercicio::create([
            'rutina_id'=>$rutina->id_rutinas,
            'ejercicio_id'=>$ejercicio['id'],
            'target_sets'=>$ejercicio['sets'],
            'target_reps'=>$ejercicio['reps'],
            'rest_seconds'=>$ejercicio['rest'],
        ]);

    }
    return response()->json(['success'=>true,'mensaje'=>'Rutina guardad correctamente']);
    }

    

    public function obtenerEjerciciosPorGrupo($id_grupo){
        $ejercicios = Ejercicio::where('grupo_muscular_id',$id_grupo)->get();
        return response()->json($ejercicios);
    }

    public function show($id){
        $rutina = Rutina::with('ejercicios.detalleEjercicio')
        ->where('usuario_id', Auth::id())
        ->findOrFail($id);

        return view('rutinas.show', compact('rutina'));

    }

    public function destroy($id){
        $rutina = Rutina::where('usuario_id', Auth::id())->findOrFail($id);
        $rutina->delete();
        return redirect('/rutinas')->with('mensaje','Rutina enviada a la papelera');
    }

    public function edit($id){
        $rutina = Rutina::with('ejercicios.detalleEjercicio')
        ->where('usuario_id',\Auth::id())
        ->findOrFail($id);

        $grupos =GrupoMuscular::all();
        return view('rutinas.edit',compact('rutina','grupos'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'nombre'=>'required|string|max:255',
            'ejercicios'=>'required|array|min:1',
        ]);

        $rutina = Rutina::where('usuario_id',\Auth::id())->findOrFail($id);
        //actualizamos el nombre y la descripcion
        $rutina->update([
            'nombre'=>$request->nombre,
            'descripcion'=> $request->descripcion,
            'dia_asignado'=>$request->dia_asignado,
        ]);

        \App\Models\RutinaEjercicio::where('rutina_id',$rutina->id_rutinas)->delete();
        foreach($request->ejercicios as $ejercicio){
            \App\Models\RutinaEjercicio::create([
                'rutina_id'=>$rutina->id_rutinas,
                'ejercicio_id'=>$ejercicio['id'],
                'target_sets'=>$ejercicio['sets'],
                'target_reps'=>$ejercicio['reps'],
                'rest_seconds'=>$ejercicio['rest'],
            ]);
        }
        return response()->json(['success'=> true]);

    }
    public function papelera(){
            $rutinas = Rutina::onlyTrashed()
            ->where('usuario_id',\Auth::id())
            ->get();

            return view('rutinas.papelera', compact('rutinas'));
    }

    public function restaurar($id){
        $rutina = Rutina::onlyTrashed()->where('usuario_id',\Auth::id())->findOrFail($id);
        $rutina->restore();
        return redirect('/rutinas')->with('mensaje','Rutina restaurada con exito');
    }
}
