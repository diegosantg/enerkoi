<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * ONBOARDING: Muestra el formulario para completar el perfil por primera vez.
     */
    public function mostrarFormulario(){
        if(Auth::user()->perfil){
            return redirect('/dashboard');
        }
        return view('completar-perfil');
    }

    /**
     * ONBOARDING: Guarda los datos físicos iniciales.
     */
    public function guardar(Request $request){
        $request->validate([
            'estatura'=>'required|integer|min:100|max:250',
            'peso_inicial'=>'required|numeric|min:30|max:300',
            'fecha_nacimiento'=>'required|date',
            'objetivo'=>'required|in:Ganar masa muscular,Perder grasa,Recomposición corporal,Mantenimiento',
            'sexo'=>'required|in:Masculino,Femenino,Prefiero no decirlo',
        ]);

        Perfil::create([
            'usuario_id'=>Auth::id(),
            'estatura'=> $request->estatura,
            'peso_inicial'=> $request->peso_inicial,
            'fecha_nacimiento'=>$request->fecha_nacimiento,
            'objetivo'=>$request->objetivo, 
            'sexo'=>$request->sexo,
        ]);

        return redirect('/dashboard');
    }

    /**
     * CONFIGURACIÓN: Muestra la vista de ajustes de usuario.
     */
    public function mostrarAjustes() {
        return view('configuracion');
    }

    /**
     * CONFIGURACIÓN: Actualiza el nombre, email y la foto de perfil.
     */
    public function actualizar(Request $request) {
        $user = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,heic|max:20480', 
        ]);

        $user->nombre = $request->nombre;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $rutaImagen = $request->file('avatar')->store('avatars', 'public');

            $user->avatar = $rutaImagen;
        }

        $user->save();

        return redirect('/dashboard')->with('mensaje', 'Perfil actualizado con éxito');
    }
}