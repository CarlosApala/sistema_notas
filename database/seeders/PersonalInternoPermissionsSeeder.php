<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PersonalInternoPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'personal_interno.crear',
            'personal_interno.editar',
            'personal_interno.eliminar',
            'personal_interno.eliminados',
            'personal_interno.restaurar',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);

        }
    }
}
