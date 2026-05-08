<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregamos la columna 'avatar'. 
            // Le ponemos nullable() porque al registrarse, los usuarios aún no tienen foto.
            $table->string('avatar')->nullable()->after('email'); 
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Esto es por si algún día necesitas revertir la migración
            $table->dropColumn('avatar');
        });
    }
};
