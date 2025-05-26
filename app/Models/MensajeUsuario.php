<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeUsuario extends Model
{
    protected $table = 'tbl_mensaje_usuario';

    public function mensaje()
    {
        return $this->belongsTo(Mensaje::class, 'id_mensaje');
    }
}
