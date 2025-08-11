<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rutas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'NombreRuta',
        'zona_id'
    ];
    protected $dates = ['deleted_at'];
    protected $table = 'rutas';

    public function getNombreAttribute()
    {
        return $this->NombreRuta;
    }
    public function zona()
    {
        return $this->belongsTo(Zonas::class, 'zona_id'); // asegúrate del nombre correcto del FK
    }

    public function predios()
    {
        return $this->belongsToMany(
            Predio::class,
            'ruta_instalaciones',
            'idRuta',   // FK en ruta_instalaciones para rutas
            'idPredio'  // FK en ruta_instalaciones para predios
        )->withPivot('nInstalacion', 'idZona')->withTimestamps();
    }
     public function rutaInstalaciones()
    {
        return $this->hasMany(RutaInstalaciones::class, 'idRuta');
    }
}
