<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $table = 'materias';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'descripcion',
        'carrera_id',
        'profesor_id',

    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    protected $guarded = [];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_materia', 'id_materia', 'alumno_id');
    }
}
