<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RutaInstalacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Supongamos que tienes IDs válidos en la base de datos:
        $zonas = DB::table('zonas')->pluck('id')->toArray();
        $rutas = DB::table('rutas')->pluck('id')->toArray();
        $predios = DB::table('predio')->pluck('id')->toArray();

        // Número de registros a insertar (puedes ajustar)
        $cantidad = 2000;

        for ($i = 0; $i < $cantidad; $i++) {
            // Elegir aleatoriamente IDs válidos
            $idZona = $faker->randomElement($zonas);
            $idRuta = $faker->randomElement($rutas);
            $idPredio = $faker->randomElement($predios);

            // nInstalacion puede ser un código generado
            $nInstalacion = 'INST-' . strtoupper($faker->bothify('??###'));

            DB::table('ruta_instalaciones')->insert([
                'idZona' => $idZona,
                'idRuta' => $idRuta,
                'idPredio' => $idPredio,
                'nInstalacion' => $nInstalacion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
