<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class LecturadoresPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            'lecturadores.crear',
            'lecturadores.editar',
            'lecturadores.eliminar',
            'lecturadores.eliminados',
            'lecturadores.restaurar',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'programa'=>"lecturadores"]);
        }
    }
}
