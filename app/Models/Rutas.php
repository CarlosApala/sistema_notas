<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';
    public $incrementing = false; // No hay un ID autoincremental
    public $timestamps = false;   // No existen campos created_at / updated_at

    // Clave primaria compuesta (Laravel no la maneja directamente en Eloquent)
    protected $primaryKey = null;

    protected $fillable = [
        'cod_rutazona',
        'cod_ruta',
        'descripcion',
    ];

    // 🔧 Importante: para evitar errores al guardar o actualizar
    protected $casts = [
        'cod_rutazona' => 'integer',
        'cod_ruta' => 'integer',
    ];

    // Si quieres forzar manualmente el uso de claves compuestas:
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->cod_rutazona || !$model->cod_ruta) {
                throw new \Exception('Campos cod_rutazona y cod_ruta son requeridos como clave primaria compuesta.');
            }
        });
    }
}
