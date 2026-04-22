<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable   implements MustVerifyEmail
{ 
    use Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey='id_usuario';

    protected $fillable = [

    'nombre',
    'apellido_p',
    'apellido_m',
    'email',
    'password',


    ];

    protected $hidden = [
        'password',
    ];

    public function perfil(){
        return $this->hasOne(Perfil::class, 'usuario_id','id_usuario');
    }

    public function rutinas(){
        return $this->hasMany(Rutina::class,'usuario_id','id_usuario');
    }

}
