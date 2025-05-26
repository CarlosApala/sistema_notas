<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaCursoProfesor extends Model
{
    protected $table = 'materia_curso_profesor';

    protected $fillable = [
        'curso_id',
        'materia_id',
        'profesor_id',
        'paralelo_id',
        'turno_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia()
{
    return $this->belongsTo(Materia::class, 'materia_id'); // columna materia_id en materia_curso_profesor
}


    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
     public function alumnos()
    {
        return $this->belongsToMany(
            Alumno::class,
            'alumno_materia',
            'materia_curso_profesor_id',
            'alumno_id'
        )->withTimestamps();
    }
}
