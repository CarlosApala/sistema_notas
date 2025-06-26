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
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'personal_id');
    }
}
