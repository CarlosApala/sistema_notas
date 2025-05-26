<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
   use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'fecha',
        'hora',
        'asistio',
    ];

    // Relación con Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}
