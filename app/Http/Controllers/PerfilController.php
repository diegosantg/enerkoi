<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function mostrarFormulario(){
        if(Auth::user()->perfil){
            return redirect('/dashboard');
        }
        return view('completar-perfil');
    }

    public function guardar(Request $request){
        $request->validate([
            'estatura'=>'required|integer|min:100|max:250',
            'peso_inicial'=>'required|numeric|min:30|max:300',
            'fecha_nacimiento'=>'required|date',
            'objetivo'=>'required|in:Ganar masa muscular,Perder grasa,Recomposición corporal,Mantenimiento',
        ]);

        Perfil::create([
            'usuario_id'=>Auth::id(),
            'estatura'=> $request->estatura,
            'peso_inicial'=> $request->peso_inicial,
            'fecha_nacimiento'=>$request->fecha_nacimiento,
            'objetivo'=>$request->objetivo, 
        ]);

        return redirect('/dashboard');
    }
}
