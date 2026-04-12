<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutinaEjercicio extends Model
{
    protected $table='rutinas_ejercicios';
    protected $primaryKey = 'id_r_e';

    public $timestamps = false;

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'target_sets',
        'target_reps'
    ];

    public function detalleEjercicio(){
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id','id_ejercicio');
    }
}
