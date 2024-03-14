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
        Schema::create('orden_venta_accesorios',function(Blueprint $table){
         $table->id();
         $table->foreignId('orden_venta')->constrained("orden_venta");
         $table->foreignId('accesorio')->constrained();
         $table->integer('cantidad');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_venta_accesorios');
    }
};
