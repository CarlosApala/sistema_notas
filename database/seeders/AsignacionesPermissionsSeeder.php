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
            'asignaciones.view',
            'asignaciones.show',
            'asignaciones.create',
            'asignaciones.edit',
            'asignaciones.delete',
            'asignaciones.view_deleted',
            'asignaciones.restore',
        ];

        foreach ($permisos as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
