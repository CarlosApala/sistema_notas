<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PrediosPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permisos = [
            'predios.crear',
            'predios.editar',
            'predios.eliminar',
            'predios.eliminados',
            'predios.restaurar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
