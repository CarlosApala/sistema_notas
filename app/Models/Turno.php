<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
  public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
