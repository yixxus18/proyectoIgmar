<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable=['fecha_cita','motivo_cita','estado_cita','marca_celular','modelo_celular','usuario','hora_cita'];

    public function usuario()
    {
     return $this->belongsTo(User::class);
    }
}
