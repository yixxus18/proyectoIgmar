<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;
    protected $table = 'reporte';
    protected $primaryKey = 'id_reporte';
    public $timestamps = false;

    protected $fillable = [
        'precio',
        'fecha_entrega',
        'id_ingresos'
    ];

    public function id_ingresos()
    {
        return $this->belongsTo(Ingreso_Reparacion::class);
    }
}
