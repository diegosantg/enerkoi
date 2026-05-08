<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';
    protected $primaryKey = 'id_ejercicio';

    protected $fillable = [
    'api_id',
    'nombre',
    'nombre_espanol',
    'gif_url',
    'descripcion',
    'grupo_muscular_id',
    'video_youtube',

    ];

    public function grupoMuscular(){
        return $this->belongsTo(GrupoMuscular::class, 'grupo_muscular_id','id_grupos_musculares' );
    }
}
