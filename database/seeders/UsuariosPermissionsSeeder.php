<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UsuariosPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        $permisos = [
            'usuarios.view',
            'usuarios.show',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.delete',
            'usuarios.view_deleted',
            'usuarios.restore',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
