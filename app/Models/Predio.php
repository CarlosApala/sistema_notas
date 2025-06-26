<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Predio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'predio'; // Indica el nombre correcto de la tabla
    protected $fillable = [
        'direccion',
        'ubicaciongps',
        'zonaBarrio',
        'distrito',
        'UnidadVecinal',
        'Manzana',
        'AreaPredio',
        'LongitudFrente',
        'AreaConstruida',
        'NroHaitaciones',
        'NroPisos',
        'NroGrifos',
        'NroBaños',
        'TipoEdificacion',
        'Pavimento',
        'EstadoEdificacion',
        'PredioHabitado',
        'Observaciones',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    // Accessor para updated_at con formato YYYY-MM-DD
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
