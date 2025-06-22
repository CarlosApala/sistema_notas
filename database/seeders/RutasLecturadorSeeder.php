<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutasLecturadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lecturadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'lecturador'); // usa el nombre del rol
        })->take(10)->get();

        if ($lecturadores->isEmpty()) {
            $this->command->error("No se encontraron usuarios con el rol 'lecturador'");
            return;
        }

        $rutas = DB::table('ruta_instalaciones')->take(1000)->pluck('id')->toArray();

        if (empty($rutas)) {
            $this->command->error("No se encontraron rutas en 'ruta_instalaciones'");
            return;
        }

        $chunkedRutas = array_chunk($rutas, 100);
        $periodo = now()->format('m/y'); // Ej: 06/25

        foreach ($lecturadores as $index => $lecturador) {
            if (!isset($chunkedRutas[$index])) {
                break;
            }

            foreach ($chunkedRutas[$index] as $rutaId) {
                DB::table('rutas_lecturador')->insert([
                    'idRuta' => $rutaId,
                    'idUser' => $lecturador->id,
                    'periodo' => $periodo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->info("Asignadas 100 rutas al usuario ID {$lecturador->id} para el periodo {$periodo}");
        }
    }


}
