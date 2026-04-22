<?php
namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\GrupoMuscular;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function index(Request $request)
    {
        $grupos = GrupoMuscular::all();
        $query = Ejercicio::with('grupoMuscular');

        //Barra de busqueda
        if ($request->filled('buscar')){
            $termino = $request->buscar;
            $query->where(function($q) use($termino){
                $q->where('nombre_espanol', 'LIKE', '%'. $termino . '%')
                ->orWhere('nombre', 'LIKE', '%'.$termino . '%');
            });
        }

        //Filtro de muscular
        if ($request->filled('grupo') && $request->grupo != 'todos'){
            $query->where('grupo_muscular_id', $request->grupo);
        }

        //paginamos con el paginate jejeje
        $ejercicios = $query->paginate(18)->appends($request->query());

        return view('ejercicios', compact('grupos', 'ejercicios'));
    }
}