<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Curso extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'turno_id', 'paralelo_id'];


    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
    public function materiasProfesores()
    {
        return $this->hasMany(MateriaCursoProfesor::class);
    }

    public function paralelos()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function turnos()
    {
        return $this->belongsTo(Turno::class);
    }
    public function materias()
    {
        // Muchos a muchos con tabla pivote
        return $this->belongsToMany(Materia::class, 'materia_curso_profesor', 'curso_id', 'materia_id')->withPivot('profesor_id', 'paralelo_id', 'turno_id');
    }
}
