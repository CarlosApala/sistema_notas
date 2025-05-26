<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Add this line

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // Add HasRoles trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

     // Mensajes que el usuario recibe (muchos a muchos)
    public function mensajes()
    {
        return $this->belongsToMany(Mensaje::class, 'tbl_mensaje_usuario', 'id_usuario', 'id_mensaje')
                    ->withPivot('leido', 'leido_en')
                    ->withTimestamps();
    }

    // Mensajes que el usuario creó (uno a muchos)
public function mensajesCreados()
{
    return $this->hasMany(Mensaje::class, 'id_usuario', 'id');
}
public function mensajesCreadosActivos()
{
    return $this->hasMany(Mensaje::class, 'id_usuario', 'id')->where('estado', 1);
}

}
