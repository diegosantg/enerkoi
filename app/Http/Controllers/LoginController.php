<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function mostrarFormulario() {
        return view('login');
    }

    public function autenticar(Request $request){
        $credenciales=$request->validate([
            'email'=>['required','email'],
            'password'=>['required'],
        ]);

        if (Auth::attempt($credenciales)){
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email'=>'El correo y/o la contraseña no coinciden',
        ])->onlyInput('email');
    }
}
