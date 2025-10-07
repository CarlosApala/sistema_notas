<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UsuarioMovil extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuarios_movil'; // nombre exacto de tu tabla
    protected $primaryKey = 'usuario';    // tu clave primaria es usuario
    public $incrementing = false;         // porque la PK no es autoincremental
    public $timestamps = false;           // tu tabla no tiene created_at/updated_at

    protected $keyType = 'string';        // bpchar es tratado como string

    protected $fillable = [
        'usuario',
        'nombre',
        'clave',
    ];

    protected $hidden = [
        'clave', // opcional, para no exponer la contraseña en el JSON
    ];
}
