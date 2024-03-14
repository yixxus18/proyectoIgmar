<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas',function(Blueprint $table){
    $table->id();
    $table->date('fecha_cita');
    $table->String('motivo_cita');
    $table->String('estado_cita');
    $table->String('marca_celular');
    $table->String('modelo_celular');
    $table->foreignId('usuario')->constrained("users");
    $table->time('hora_cita');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
};
