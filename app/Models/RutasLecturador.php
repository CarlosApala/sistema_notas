<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutasLecturador extends Model
{
    use HasFactory;

    protected $table = 'rutas_lecturador';

    protected $fillable = [
        'idRuta',
        'idUser',
        'periodo',
        'created_at',
        'updated_at',
    ];

    // Relación con la tabla ruta_instalaciones
    public function rutaInstalacion()
    {
        return $this->belongsTo(RutaInstalaciones::class, 'idRuta');
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
