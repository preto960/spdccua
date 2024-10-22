<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuadrilla extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['nombre', 'descripcion','estatus'];

    // Relación con Empleados (muchos a muchos)
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'cuadrilla_empleado', 'cuadrilla_id', 'empleado_id');
    }
}
