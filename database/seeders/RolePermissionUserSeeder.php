<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionUserSeeder extends Seeder
{
    public function run(): void
    {
        // Asignar permisos a roles
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
                $role->syncPermissions($permissions);
            }
        }

        // Crear usuarios y asignarles roles
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'username' => 'editor',
                'password' => 'password',
                'role' => 'editor',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'password' => $data['password'], // encriptado por mutator
                ]
            );

            $user->assignRole($data['role']);
        }
    }
}
