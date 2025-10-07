<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    // Nombre de la tabla (por defecto sería 'zonas', pero lo indicamos por claridad)
    protected $table = 'zonas';

    // Nombre de la clave primaria
    protected $primaryKey = 'cod_zona';

    // Indicar que la clave primaria no es autoincremental (porque es INT2 sin SERIAL)
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // Desactivar timestamps (no existen columnas created_at o updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cod_zona',
        'descripcion',
        'referencia',
    ];
}
