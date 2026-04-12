<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

class Rutina extends Model
{
    use SoftDeletes, Prunable;
    protected $table= 'rutinas';
    protected $primaryKey = 'id_rutinas';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
        'dia_asignado'
    ];

    public function ejercicios(){
        return $this->hasMany(RutinaEjercicio::class, 'rutina_id','id_rutinas');
    }

    public function prunable()
    {
        return static::where('deleted_at','<=', now()->subDays(30));
    }
}
