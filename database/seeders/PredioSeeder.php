<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PredioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run(): void
    {
        $faker = Faker::create('es_ES');

        foreach (range(1, 500) as $i) {
            DB::table('predio')->insert([
                'direccion' => $faker->streetAddress,
                'ubicaciongps' => $faker->latitude . ',' . $faker->longitude,
                'zonaBarrio' => $faker->word,
                'distrito' => 'Distrito ' . $faker->numberBetween(1, 5),
                'UnidadVecinal' => 'UV-' . $faker->numberBetween(1, 20),
                'Manzana' => 'MZ-' . strtoupper($faker->randomLetter),
                'AreaPredio' => $faker->randomFloat(2, 50, 500),
                'LongitudFrente' => $faker->randomFloat(2, 5, 50),
                'AreaConstruida' => $faker->randomFloat(2, 30, 400),
                'NroHaitaciones' => $faker->numberBetween(1, 10),
                'NroPisos' => $faker->numberBetween(1, 5),
                'NroGrifos' => $faker->numberBetween(1, 5),
                'NroBaños' => $faker->numberBetween(1, 5),
                'TipoEdificacion' => $faker->randomElement(['Casa', 'Departamento', 'Edificio']),
                'Pavimento' => $faker->boolean,
                'EstadoEdificacion' => $faker->randomElement(['Bueno', 'Regular', 'Malo']),
                'PredioHabitado' => $faker->boolean,
                'Observaciones' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
