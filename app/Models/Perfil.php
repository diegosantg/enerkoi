<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'id_perfil';


    protected $fillable = [
        'usuario_id',
        'estatura',
        'sexo',
        'peso_inicial',
        'fecha_nacimiento',
        'objetivo',

    ];
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id','id_usuario');
    }
}
