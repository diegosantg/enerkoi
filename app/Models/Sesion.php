<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sesion extends Model
{
    use HasFactory;

    //nombre de la sala
    protected $table = 'sesiones';

    //Columnas para llenar
    protected $fillable = [
        'usuario_id',
        'rutina_id',
        'duracion_segundos',
    ];

    public function series(){
        return $this->hasMany(SesionSerie::class,'sesion_id');
    }
}
