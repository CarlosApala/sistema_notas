<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AsignacionesPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permisos = [
            'asignaciones.crear',
            'asignaciones.editar',
            'asignaciones.eliminar',
            'asignaciones.eliminados',
            'asignaciones.restaurar',
        ];

        foreach ($permisos as $permission) {
            Permission::firstOrCreate(['name' => $permission,'programa'=>'asignaciones']);
        }
    }
}
