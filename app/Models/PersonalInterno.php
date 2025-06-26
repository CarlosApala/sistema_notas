<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalInterno extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'personal_interno';

    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'carnet_identidad',
        'nacionalidad',
        'numero_celular',
        'estado_civil',
        'direccion',
        'genero',
        'lugar_nacimiento',
        'email',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'personal_id');
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
}
