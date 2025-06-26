<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
                'password' => 'password',  // Se cifrará más abajo
                'role' => 'admin',
            ]
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'password' => $data['password'],
                ]
            );

            $role = Role::findByName($data['role']);
            $permisos = $role->permissions;
            $user->givePermissionTo($permisos);
            $user->assignRole($role);

            $this->command->info("Usuario creado y asignado al rol: {$data['role']} - {$data['email']}");
        }
    }
}
