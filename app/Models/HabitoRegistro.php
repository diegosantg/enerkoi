<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitoRegistro extends Model
{
    use HasFactory;

    protected $table = 'habitos_registros';
    protected $primaryKey = 'id_registro';

    // Autorizamos las columnas para que Laravel nos deje guardar el progreso
    protected $fillable = [
        'habito_id', 
        'fecha_registro', 
        'progreso_actual', 
        'completado'
    ];

    // Convertimos los datos automáticamente al leerlos de la BD
    protected $casts = [
        'fecha_registro' => 'date',
        'completado' => 'boolean',
    ];

    // Relación: Un registro pertenece a un hábito
    public function habito()
    {
        return $this->belongsTo(Habito::class, 'habito_id', 'id_habito');
    }
}