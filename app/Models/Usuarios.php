<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false; // porque usas UUID, no autoincremental
    protected $keyType = 'string';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'clave_hash',
        'telefono',
        'estado',
        'intentos_fallidos',
        'bloqueado',
        'fecha_bloqueo',
        'fecha_creacion',
        'fecha_actualizacion',
        'ultimo_acceso',
        'foto_perfil',
        'reset_token',
        'reset_expira',
    ];

    // Desactiva timestamps automáticos si no usas created_at/updated_at
    public $timestamps = false;

    // Generar automáticamente un UUID al crear el modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_usuario) {
                $model->id_usuario = (string) Str::uuid();
            }
        });
    }
}
