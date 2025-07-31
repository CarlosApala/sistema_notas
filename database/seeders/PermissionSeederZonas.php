<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeederZonas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisosZona = [

                'zona.crear',           // Crear nueva zona
                'zona.editar',      // Editar zona
                'zona.eliminar',       // Eliminar zona
                'zona.eliminados', // Restaurar zona (si usas soft deletes)
                'zona.restaurar'
        ];

        foreach ($permisosZona as $permiso) {
            Permission::firstOrCreate(['name' => $permiso,'programa'=>'zona']);
        }
    }
}
