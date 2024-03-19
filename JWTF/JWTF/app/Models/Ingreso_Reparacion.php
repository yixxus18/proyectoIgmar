<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso_Reparacion extends Model
{
    use HasFactory;
    protected $fillable=['nombre','dispositivo','reparacion','descripcion','fecha_ingreso','estatus'];

    protected $table = 'ingresos_reparaciones';

    public $timestamps = false;
    public function celular()
    {
    return $this->belongsTo(Dispositivo::class);
    }

    public function reparacion()
    {
    return $this->belongsTo(Reparacion::class); 
    }


    public function user()
    {
        return$this->belongsTo(User::class);
    }
}
