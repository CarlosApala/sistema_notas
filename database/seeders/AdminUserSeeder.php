<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     // Crear usuario admin
        $user = User::create([
    'name' => 'Admin',
    'username' => 'admin',  // <-- Agrega esto
    'email' => 'admin@example.com',
    'password' => 'secret', // Cambia la contraseña si quieres
]);


        // Asignar rol admin
        $role = Role::where('name', 'admin')->first();
        $user->assignRole($role);
    }
}
