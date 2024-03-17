<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    use HasFactory;
     protected $fillable=['tipo_reparaciones'];

     protected $table = 'reparaciones';

     public $timestamps = false;


     public function ingreso_reparacion()
     {
        return $this->hasMany(Ingreso_Reparacion::class);
     }
}
