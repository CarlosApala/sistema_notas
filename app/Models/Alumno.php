<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Alumno extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'alumnos';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'matricula',
        'direccion',
        'telefono',
        'fecha_nacimiento',
        'sexo',
        'edad',
        'fecha_ingreso',
        'estatus',
        'observaciones',
        'foto',
        'curso_id',
        'turno_id',
        'paralelo_id'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
   public function materiasAsignadas()
{
    return $this->belongsToMany(
        MateriaCursoProfesor::class,    // Modelo relacionado
        'alumno_materia',               // Tabla pivote
        'alumno_id',                   // FK en pivote hacia Alumno
        'materia_curso_profesor_id'    // FK en pivote hacia MateriaCursoProfesor
    );
}


    // En Alumno.php (Modelo)
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'alumno_materia', 'alumno_id', 'materia_id');
    }

    public function materiasCursoProfesor()
    {
        return $this->belongsToMany(MateriaCursoProfesor::class, 'alumno_materia', 'alumno_id', 'materia_curso_profesor_id');
    }
}
