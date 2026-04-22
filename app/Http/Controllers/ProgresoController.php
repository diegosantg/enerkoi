<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesion;
use Carbon\Carbon;

class ProgresoController extends Controller
{
    public function index(){
        $usuarioId= auth()->id();
        //Buscamos las sesiones
        $sesiones = Sesion::where('usuario_id', $usuarioId)
        ->orderBy('created_at','asc')
        ->get();

        //Metricas para el panel
        $totalEntrenamientos = $sesiones->count();
        $tiempoTotalSegundos = $sesiones->sum('duracion_segundos');

        //formato en hrs
        $horas = floor($tiempoTotalSegundos/3600);
        $minutos = floor(($tiempoTotalSegundos % 3600) / 60);
        $tiempoTotalFormato ="{$horas}h {$minutos}m";

        //Datos para graficos
        $fechasGrafico = [];
        $tiemposGrafico = [];

        foreach($sesiones as $sesion){
            //mera fecha
            $fechaCorta = $sesion->created_at->format('Y-m-d');

            $minutosSesion = round($sesion->duracion_segundos/60);

            if(isset($tiemposGrafico[$fechaCorta])){
                $tiemposGrafico[$fechaCorta] += $minutosSesion;
            }else{
                $fechasGrafico[]= $fechaCorta;
                $tiemposGrafico[$fechaCorta] = $minutosSesion;
            }
        }

        //Mandameos todo a la vista 
        return view('progreso',[
            'totalEntrenamientos'=>$totalEntrenamientos,
            'tiempoTotalFormato' => $tiempoTotalFormato,

            //arreglos json
            'fechasGraficoJS'=>json_encode(array_values($fechasGrafico)),
            'tiemposGraficoJS'=> json_encode(array_values($tiemposGrafico))
        ]);
    }
}
