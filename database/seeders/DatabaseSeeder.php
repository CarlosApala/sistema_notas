<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Predio;
use App\Models\RutasLecturador;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* $this->call([
            AdminUserSeeder::class,
            // aquí puedes agregar otros seeders si tienes
        ]); */
        $this->call([
            RoleSeeder::class
        ]);

        $this->call([
            PermissionSeeder::class,
        ]);

        $this->call([
            RolePermissionSeeder::class
        ]);
        $this->call([
            UserRoleSeeder::class
        ]);
        $this->call([
            PredioSeeder::class,
            InstalacionSeeder::class,
            RutasSeeder::class,
            ZonasSeeder::class,
            RutaInstalacionesSeeder::class,
            RutasLecturadorSeeder::class,
            PersonalInternoSeeder::class
        ]);
    }
}
