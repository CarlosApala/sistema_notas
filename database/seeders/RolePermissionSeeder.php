<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rolePermissions = [
            'admin' => [
                'create users',
                'edit users',
                'delete users',
                'view users',
                'create posts',
                'edit posts',
                'delete posts',
                'view posts',
            ],
            'editor' => [
                'create posts',
                'edit posts',
                'delete posts',
                'view posts',
            ],
            /* 'viewer' => [
                'view users',
                'view posts',
            ], */
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                // Asigna y sincroniza permisos para evitar duplicados o permisos sobrantes
                $role->syncPermissions($permissions);
                $this->command->info("Permisos asignados al rol: {$roleName}");
            } else {
                $this->command->warn("Rol no encontrado: {$roleName}");
            }
        }
    }
}
