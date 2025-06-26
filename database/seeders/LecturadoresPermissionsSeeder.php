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
            'lecturadores.view',
            'lecturadores.show',
            'lecturadores.create',
            'lecturadores.edit',
            'lecturadores.delete',
            'lecturadores.view_deleted',
            'lecturadores.restore',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
