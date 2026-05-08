<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rutina;
use App\Models\Habito;

class DashboardController extends Controller
{
    public function index(){
       $usuario = Auth::user();
       
       $ultimasRutinas = Rutina::where('usuario_id',$usuario->id_usuario)
       ->orderBy('created_at', 'desc')
       ->take(3)
       ->get();

       $rutinas = \App\Models\Rutina::where('usuario_id', auth()->id())->get();

       // LÓGICA INTELIGENTE DE HÁBITOS (HORA DE MÉXICO)
       $hoy = now()->timezone('America/Mexico_City');
       $fechaHoy = $hoy->toDateString();

       // Traemos todos los hábitos y su progreso de HOY
       $todosLosHabitos = Habito::with(['registros' => function($query) use ($fechaHoy) {
           $query->where('fecha_registro', $fechaHoy);
       }])
       ->where('usuario_id', $usuario->id_usuario)
       ->orderBy('created_at', 'desc')
       ->get();

       // Filtramos para dejar solo los pendientes que tocan hoy
       $habitosDashboard = $todosLosHabitos->filter(function($habito) use ($hoy) {
           // 1. Si ya se completó hoy, no lo mostramos en el Dashboard
           $registroHoy = $habito->registros->first();
           if ($registroHoy && $registroHoy->completado) {
               return false; 
           }

           // 2. Extraemos la frecuencia guardada
           $frecuencia = is_array($habito->frecuencia) ? ($habito->frecuencia[0] ?? 'diario') : ($habito->frecuencia ?? 'diario');
           $fechaCreacion = $habito->created_at->timezone('America/Mexico_City');

           // 3. Verificamos si le toca hoy
           if ($frecuencia === 'diario') return true;
           if ($frecuencia === 'semanal' && $hoy->dayOfWeekIso === $fechaCreacion->dayOfWeekIso) return true;
           if ($frecuencia === 'mensual' && $hoy->day === $fechaCreacion->day) return true;

           return false; // Si no cumplió nada, no toca hoy
       })->take(2); // Tomamos solo los primeros 2
       
       return view('dashboard',compact('usuario','ultimasRutinas', 'rutinas', 'habitosDashboard'));
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}