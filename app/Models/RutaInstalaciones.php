<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RutaInstalaciones extends Model
{
    use HasFactory;
    protected $table = 'ruta_instalaciones';

    protected $fillable = ['idZona', 'idRuta', 'idPredio', 'nInstalacion'];


    // Si tienes campos protegidos o no usas timestamps, puedes declararlo también:
    // public $timestamps = false;

    // Relaciones
    public function zona()
    {
        return $this->belongsTo(Zonas::class, 'idZona');
    }

    public function ruta()
    {
        return $this->belongsTo(Rutas::class, 'idRuta');
    }

    public function predio()
    {
        return $this->belongsTo(Predio::class, 'idPredio');
    }

    // Método para obtener el código completo como 1.13.69.10
    public function getCodigoCompletoAttribute()
    {
        $zona = $this->zona ? $this->zona->numero ?? $this->zona->id : '0';
        $ruta = $this->ruta ? $this->ruta->numero ?? $this->ruta->id : '0';
        $predio = $this->predio ? $this->predio->numero ?? $this->predio->id : '0';
        $instalacion = $this->nInstalacion ?? '0';

        return "{$zona}.{$ruta}.{$predio}.{$instalacion}";
    }
}
