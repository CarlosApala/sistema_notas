<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Calificacion extends Model
{
    use HasFactory;

    use HasFactory, Notifiable;

    protected $table='calificaciones';

    protected $primaryKey ='id';

    public $timestamps=true;

    protected $fillable = [
        'calificacion',
        'alumno_id',
        'materia_id',
        'profesor_id',
        'carrera_id',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}
