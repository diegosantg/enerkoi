<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rutina;

class DashboardController extends Controller
{
    public function index(){
        //usuario en curso
       $usuario = Auth::user();
       //VAr para las 3 ultimas rutinas
       $ultimasRutinas = Rutina::where('usuario_id',$usuario->id_usuario)
       ->orderBy('created_at', 'desc')
       ->take(3)
       ->get();
       return view('dashboard',compact('usuario','ultimasRutinas'));
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
