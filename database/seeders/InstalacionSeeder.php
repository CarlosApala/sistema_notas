<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class InstalacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run(): void
    {
        $faker = Faker::create();

        for ($idPredio = 1; $idPredio <= 500; $idPredio++) {
            $instalacionesCount = rand(1, 3);

            for ($i = 0; $i < $instalacionesCount; $i++) {
                DB::table('instalacions')->insert([
                    'idPredio' => $idPredio,
                    'FechaInstalacion' => $faker->date(),
                    'NumeroMedidor' => $faker->numerify('MED###'),
                    'EstadoInstalacion' => $faker->randomElement(['Activa', 'Inactiva', 'Pendiente']),
                    'EstadoAlcantarillado' => $faker->randomElement(['Bueno', 'Regular', 'Malo']),
                    'Observaciones' => $faker->optional()->sentence(),
                    'NroGrifos' => $faker->numberBetween(1, 5),
                    'NroBaños' => $faker->numberBetween(1, 3),
                    'EstadoCorte' => $faker->randomElement(['Cortado', 'Activo']),
                    'PromedioConsumo' => $faker->randomFloat(2, 5, 50),
                    'CodigoUbicacion' => $faker->bothify('CU-###??'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
