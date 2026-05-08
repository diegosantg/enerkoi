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
        Schema::create('habitos', function (Blueprint $table) {
            $table->id('id_habito'); 
            
            // CAMBIO CLAVE: Usamos unsignedInteger en lugar de unsignedBigInteger
            $table->unsignedInteger('usuario_id'); 
            
            $table->string('nombre');
            $table->string('icono')->nullable();
            $table->enum('tipo', ['binario', 'numerico'])->default('binario');
            $table->integer('meta_numerica')->nullable(); 
            $table->string('unidad')->nullable(); 
            $table->json('frecuencia'); 
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitos');
    }
};
