<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habito extends Model
{
    use HasFactory;

    protected $table = 'habitos';
    protected $primaryKey = 'id_habito';

    // ¡Aquí está el escudo protector de Laravel arreglado!
    protected $fillable = [
        'usuario_id', 'nombre', 'icono', 'tipo', 'meta_numerica', 
        'unidad', 'frecuencia', 'fecha_inicio', 'fecha_fin'
    ];

    protected $casts = [
        'frecuencia' => 'array', 
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function registros()
    {
        return $this->hasMany(HabitoRegistro::class, 'habito_id', 'id_habito');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
}