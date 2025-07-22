<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el usuario con ID 1
        $usuario = User::find(1);

        if ($usuario) {
            // Obtener todos los permisos disponibles
            $permisos = Permission::all();

            // Asignar todos los permisos directamente al usuario
            $usuario->syncPermissions($permisos);

            $this->command->info("Todos los permisos han sido asignados directamente al usuario con ID 1");
        } else {
            $this->command->warn("Usuario con ID 1 no encontrado");
        }
    }
}
