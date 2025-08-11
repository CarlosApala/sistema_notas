<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class InstalacionesPermissionsSeeder extends Seeder
{

    public function run()
    {
        $permissions = [
            'instalaciones.crear',
            'instalaciones.editar',
            'instalaciones.eliminar',
        ];

        foreach ($permissions as $perm) {
            // Evita insertar permisos duplicados
            Permission::firstOrCreate(['name' => $perm,'programa'=>'instalaciones']);
        }
    }
}
