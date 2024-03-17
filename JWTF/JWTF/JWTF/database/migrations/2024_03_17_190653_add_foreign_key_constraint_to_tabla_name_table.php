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
        Schema::table('reparacion_dispositivos', function (Blueprint $table) {
            $table->foreignId('dispositivo_id')->references('id')->on('dispositivos')->onDelete('cascade');
            $table->foreignId('reparaciones_id')->references('id')->on('reparaciones')->onDelete('cascade');
        });

        Schema::table('accesorios', function (Blueprint $table) {
            $table->foreignId('categoria')->references('id')->on('categorias')->onDelete('cascade');
          
        });

        Schema::table('orden_venta', function (Blueprint $table) {
            $table->foreignId('user')->references('id')->on('users')->onDelete('cascade');
          
        });

        Schema::table('orden_venta', function (Blueprint $table) {
            $table->foreignId('user')->references('id')->on('users')->onDelete('cascade');
          
        });

        Schema::table('orden_venta', function (Blueprint $table) {
            $table->foreignId('user')->references('id')->on('users')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabla_name', function (Blueprint $table) {
            
        });
    }
};
