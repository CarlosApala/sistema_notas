<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Profesor extends Model
{
    use HasFactory, Notifiable;

    protected $table='profesores';

    protected $primaryKey ='id';

    public $timestamps=true;


    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'cedula',
        'experiencia',
        'fecha_contratacion',
        'materia_id',
        'carrera_id',


    ];

    public function materia()
{
    return $this->belongsTo(Materia::class, 'materia_id');
}

public function carrera()
{
    return $this->belongsTo(Carrera::class, 'carrera_id');
}

public function materiasCursos()
    {
        return $this->hasMany(MateriaCursoProfesor::class);
    }

    protected $guarded = [

    ];
}
