<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el usuario con ID 1
        $usuarioId = 1;

        // Verificar si el usuario existe (opcional si ya estás seguro)
        if (User::find($usuarioId)) {
            // Obtener todos los IDs de los permisos disponibles
            $permisosIds = Permission::pluck('id');

            // Crear un array de inserciones
            $datos = $permisosIds->map(function ($permisoId) use ($usuarioId) {
                return [
                    'users_id' => $usuarioId,
                    'permissions_id' => $permisoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            // Insertar en la tabla intermedia
            DB::table('user_permisos')->insert($datos);

            $this->command->info("Todos los permisos han sido asignados al usuario con ID 1 en la tabla user_permisos.");
        } else {
            $this->command->warn("Usuario con ID 1 no encontrado.");
        }
    }
}
