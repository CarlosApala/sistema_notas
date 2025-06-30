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
            'zona.index',     // Ver lista
            'zona.ver',       // Ver detalles
            'zona.crear',     // Crear nueva zona
            'zona.editar',    // Editar zona
            'zona.eliminar',  // Eliminar zona
            'zona.restaurar', // Restaurar zona (si usas soft deletes)
        ];

        foreach ($permisosZona as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
