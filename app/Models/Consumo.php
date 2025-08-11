<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    use HasFactory;
    protected $table = 'consumos';

    protected $fillable = [
        'idInstalacion',
        'consumo',
        'foto',
        'periodo',
        'observaciones',
        'fecha_registro',
    ];
    // Relación: un consumo pertenece a una instalación
    public function instalacion()
    {
        return $this->belongsTo(Instalacion::class, 'idInstalacion', 'id');
    }
}
