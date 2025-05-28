<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => 'password',  // Recuerda que debe encriptarse con mutator o bcrypt
                'role' => 'admin',
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'username' => 'editor',
                'password' => 'password',
                'role' => 'editor',
            ],
            [
                'name' => 'Viewer User',
                'email' => 'viewer@example.com',
                'username' => 'viewer',
                'password' => 'password',
                'role' => 'viewer',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'password' => $data['password'],  // Encripta aquí si no usas mutator
                ]
            );

            $role = \Spatie\Permission\Models\Role::findByName($data['role']);
            $permisos = $role->permissions;
            $user->givePermissionTo($permisos);

            $user->assignRole($data['role']);
            $this->command->info("Usuario creado y asignado al rol: {$data['role']} - {$data['email']}");
        }
    }
}
