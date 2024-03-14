<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion_Dispositivo extends Model
{
    use HasFactory;

    protected $fillable=['dispositivo_id','reparaciones_id','id'];

    public function dispositivo_id()
    {
        return $this->belongsTo(Dispositivo::class);
    }

    public function reparaciones_id()
    {
        return $this->belongsTo(Reparacion::class);
    }
}


