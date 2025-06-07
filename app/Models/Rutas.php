<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    use HasFactory;
    protected $table = 'rutas';
    public function getNombreAttribute()
    {
        return $this->NombreRuta;
    }
    public function zona()
    {
        return $this->belongsTo(Zonas::class); // asegúrate del nombre correcto del FK
    }
}
