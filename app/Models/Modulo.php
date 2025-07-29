<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class Modulo extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $table = 'modulos';
    protected $fillable = ['id','nombre', 'descripcion'];


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'modulo_id');
    }

}
