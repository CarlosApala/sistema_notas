<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermiso extends Model
{
    protected $table = 'user_permisos';

    protected $fillable = [
        'users_id',
        'permissions_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function permiso(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permissions_id');
    }
}
