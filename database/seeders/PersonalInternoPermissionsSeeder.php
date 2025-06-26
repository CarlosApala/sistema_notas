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
            'personal_interno.view',
            'personal_interno.show',
            'personal_interno.create',
            'personal_interno.edit',
            'personal_interno.delete',
            'personal_interno.view_deleted',
            'personal_interno.restore',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
