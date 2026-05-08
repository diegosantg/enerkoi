<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;
use Symfony\Component\Mime\Email;

class RegistroController extends Controller
{
    public function mostrarFormulario(){
        return view('registro');
    }

    public function registrar(Request $request){
        $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido_p'=>'required|string|max:255',
            'apellido_m'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:usuarios',
            'password'=>'required|string|min:8|confirmed',
            'terminos' => 'accepted',
            'newsletter' => 'nullable|boolean',
            ], [
            'terminos.accepted' => 'Debes leer y aceptar los Términos y Condiciones para crear tu cuenta.'
        ]);
        $usuario= Usuario::create([
            'nombre'=>$request->nombre,
            'apellido_p'=>$request->apellido_p,
            'apellido_m'=>$request->apellido_m,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
            'acepto_terminos' => true,
            'suscrito_newsletter' => $request->has('newsletter'),
        ]);
        event(new Registered($usuario));

        \Auth::login($usuario);
        return  redirect('/verificacion-aviso');
    }

}
