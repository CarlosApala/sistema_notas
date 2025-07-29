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
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'usuarios.eliminados',
            'usuarios.restaurar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
