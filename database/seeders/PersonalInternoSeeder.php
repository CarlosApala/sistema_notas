<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersonalInternoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('personal_interno')->insert([
            'nombres'           => "Admin",
            'apellidos'         => "User",
            'fecha_nacimiento'  => '1990-01-01',
            'carnet_identidad'  => "CI1234567",
            'nacionalidad'      => 'Boliviana',
            'numero_celular'    => '71234567',
            'estado_civil'      => 'Soltero',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
