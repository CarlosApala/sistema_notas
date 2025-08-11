<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Predio;
use App\Models\RutasLecturador;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;

use function Pest\Laravel\call;

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
        /* $this->call([
            PermissionSeeder::class
        ]); */

        $this->call([
            //PredioSeeder::class,
            //InstalacionSeeder::class,
            //RutasSeeder::class,
            //ZonasSeeder::class,
            //PersonalInternoSeeder::class,
            UserRoleSeeder::class,
            PersonalInternoPermissionsSeeder::class,
            LecturadoresPermissionsSeeder::class,
            PermissionSeederZonas::class,
            PrediosPermissionsSeeder::class,
            InstalacionesPermissionsSeeder::class,
            AsignacionesPermissionsSeeder::class,
            UsuariosPermissionsSeeder::class,
            ConfiguracionSeeder::class,
            ZonaRutasSeeder::class,
            RolePermissionSeeder::class
        ]);
    }
}
