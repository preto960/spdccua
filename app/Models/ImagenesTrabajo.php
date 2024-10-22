<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImagenesTrabajo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'imagenes_trabajo';

    protected $fillable = [
        'trabajo_id',
        'imagen_path',
    ];

    public function trabajo()
    {
        return $this->belongsTo(TrabajoSecretaria::class, 'trabajo_id');
    }
}
