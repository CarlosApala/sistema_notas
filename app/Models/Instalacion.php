<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instalacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'instalacions';

    protected $fillable = [
        'idPredio',
        'FechaInstalacion',
        'NumeroMedidor',
        'EstadoInstalacion',
        'EstadoAlcantarillado',
        'Observaciones',
        'NroGrifos',
        'NroBaños',
        'EstadoCorte',
        'PromedioConsumo',
        'CodigoUbicacion',
    ];

    protected $casts = [

        'NroGrifos' => 'integer',
        'NroBaños' => 'integer',
        'PromedioConsumo' => 'float',
    ];

    public function predio()
    {
        // La clave foránea es 'idPredio' (con mayúscula P)
        return $this->belongsTo(Predio::class, 'idPredio');
    }
    public function getFechaInstalacionAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }


    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    // Accessor para updated_at con formato YYYY-MM-DD
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    // Relación: una instalación tiene muchos consumos
    public function consumos()
    {
        return $this->hasMany(Consumo::class, 'idInstalacion', 'id');
    }
}
