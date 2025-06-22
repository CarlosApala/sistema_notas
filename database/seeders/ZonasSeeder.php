<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ZonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('zonas')->insert([
                'NombreZona' => 'Zona ' . $i . ' - ' . ucfirst($faker->word()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
