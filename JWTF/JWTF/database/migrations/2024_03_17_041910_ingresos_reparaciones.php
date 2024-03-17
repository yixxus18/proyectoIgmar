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
        Schema::create('ingresos_reparaciones',function(Blueprint $table){
       $table->id();
       $table->String('nombre');
       $table->foreignId('dispositivo')->constrained();
       $table->foreignId('reparacion')->constrained('reparaciones');
       $table->string('descripcion');
       $table->date('fecha_ingreso');
       $table->string('estatus');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};