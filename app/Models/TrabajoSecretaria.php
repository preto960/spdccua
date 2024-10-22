<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrabajoSecretaria extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'trabajo_secretaria';

    protected $fillable = [
        'problema',
        'direccion',
        'eje',
        'estatus',
        'requerimientos',
        'fecha_desde',  // Añadir campo fecha desde
        'fecha_hasta',  // Añadir campo fecha hasta
    ];

    public function imagenes()
    {
        return $this->hasMany(ImagenesTrabajo::class, 'trabajo_id');
    }
}
