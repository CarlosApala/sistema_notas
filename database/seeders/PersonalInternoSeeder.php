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
        $data = [];

        for ($i = 1; $i <= 25; $i++) {
            $data[] = [
                'nombres'           => "Nombre{$i}",
                'apellidos'         => "Apellido{$i}",
                'fecha_nacimiento'  => Carbon::now()->subYears(rand(20, 50))->subDays(rand(0, 365))->format('Y-m-d'),
                'carnet_identidad'  => "CI{$i}" . rand(1000, 9999),
                'nacionalidad'      => 'Boliviana',
                'numero_celular'    => '7' . rand(1000000, 9999999),
                'estado_civil'      => ['Soltero', 'Casado', 'Divorciado'][rand(0, 2)],
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        DB::table('personal_interno')->insert($data);
    }
}
