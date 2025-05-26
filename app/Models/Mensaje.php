<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'tbl_mensajes';
    protected $primaryKey = 'id_mensaje';

    protected $fillable = [
        'asunto',
        'contenido',
        'fecha_envio',
        'hora_envio',
        'adjunto_url',
        'tipo_mensaje',
        'para_todos',
        'estado',
        'id_usuario',  // creador del mensaje
    ];
    protected $casts = [
    'fecha_evento' => 'date',
];


    // Relación con los usuarios destinatarios (muchos a muchos)
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'tbl_mensaje_usuario', 'id_mensaje', 'id_usuario')
                    ->withPivot('leido', 'leido_en')
                    ->withTimestamps();
    }

    // Relación con el usuario creador del mensaje (uno a muchos inversa)
    public function creador()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
