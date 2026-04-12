<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoMuscular extends Model
{
    protected $table= 'grupos_musculares';
    protected $primaryKey = 'id_grupos_musculares';

    protected $fillable = [
        'nombre',
        'nombre_espanol',
    ];

    public function ejercicios(){
        return $this->hasMany(Ejercicio::class, 'grupo_muscular_id','id_grupos_musculares');
    }
}
