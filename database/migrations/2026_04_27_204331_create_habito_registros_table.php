<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('habitos_registros', function (Blueprint $table) {
            $table->id('id_registro');
            $table->unsignedBigInteger('habito_id');
            $table->date('fecha_registro'); // El día en que se hizo el hábito
            $table->integer('progreso_actual')->default(0); // Cuánto lleva ese día
            $table->boolean('completado')->default(false); // True si progreso >= meta
            $table->timestamps();

            // Relación con la tabla hábitos. Si se borra el hábito, se borra su historial.
            $table->foreign('habito_id')->references('id_habito')->on('habitos')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habito_registros');
    }
};
