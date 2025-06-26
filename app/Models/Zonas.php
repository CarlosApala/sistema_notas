<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zonas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'NombreZona'
    ];
    protected $dates = ['deleted_at'];
    protected $table = 'zonas';
    public function getNombreAttribute()
    {
        return $this->NombreZona;
    }

    public function rutas()
    {
        return $this->hasMany(Rutas::class,'zona_id');
    }
}
