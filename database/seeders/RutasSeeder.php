<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RutasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 200; $i++) {
            DB::table('rutas')->insert([
                'NombreRuta' => 'Ruta ' . $i . ' - ' . ucfirst($faker->word()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
