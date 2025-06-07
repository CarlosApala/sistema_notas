<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;


class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin1@example.com',
                'username' => 'admin1',
                'password' => 'password',  // Recuerda que debe encriptarse con mutator o bcrypt
                'role' => 'admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin2@example.com',
                'username' => 'admin2',
                'password' => 'password',  // Recuerda que debe encriptarse con mutator o bcrypt
                'role' => 'admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin3@example.com',
                'username' => 'admin3',
                'password' => 'password',  // Recuerda que debe encriptarse con mutator o bcrypt
                'role' => 'admin',
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

        $viewerRole = Role::findByName('lecturador','web');

        // Crear 10 usuarios viewer
        for ($i = 1; $i <= 10; $i++) {
            $email = "lecturador{$i}@example.com";
            $username = "lecturador{$i}";

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "lecturador User {$i}",
                    'username' => $username,
                    'password' => bcrypt('password'),
                ]
            );

            // Asignar permisos y rol
            $user->givePermissionTo($viewerRole->permissions);
            $user->assignRole($viewerRole);

            $this->command->info("Usuario lecturador{$i} creado - {$email}");

        }
    }
}
