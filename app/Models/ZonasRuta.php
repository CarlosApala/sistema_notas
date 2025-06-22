<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonasRuta extends Model
{
    use HasFactory;
    protected $table = 'zonas_rutas';
    public $timestamps = false;

    protected $fillable = ['zona_id', 'ruta_id'];

    public function zona()
    {
        return $this->belongsTo(Zonas::class);
    }

    public function ruta()
    {
        return $this->belongsTo(Rutas::class);
    }
}
