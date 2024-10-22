<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'empleados';

    // Definir los campos asignables
    protected $fillable = [
        'cedula', 'nombre', 'direccion', 'correo', 'telefono', 'grado_instruccion', 'estatus'
    ];

    // Relación con Asistencia
    public function asistencia()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function cuadrillas()
    {
        return $this->belongsToMany(Cuadrilla::class);
    }

}
