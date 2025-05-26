<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $permisos = [
            // Alumnos
            'ver alumnos', 'crear alumnos', 'editar alumnos', 'eliminar alumnos',

            // Asistencias
            'ver asistencias', 'crear asistencias', 'editar asistencias', 'eliminar asistencias',

            // Calificaciones
            'ver calificaciones', 'crear calificaciones', 'editar calificaciones', 'eliminar calificaciones',

            // Cursos
            'ver cursos', 'crear cursos', 'editar cursos', 'eliminar cursos',

            // Materias
            'ver materias', 'crear materias', 'editar materias', 'eliminar materias',

            // Paralelos
            'ver paralelos', 'crear paralelos', 'editar paralelos', 'eliminar paralelos',

            // Profesores
            'ver profesores', 'crear profesores', 'editar profesores', 'eliminar profesores',

            // Mensajes
            'ver mensajes', 'crear mensajes', 'editar mensajes', 'eliminar mensajes',

            // Mensajes Usuario
            'ver mensaje usuario', 'crear mensaje usuario', 'editar mensaje usuario', 'eliminar mensaje usuario',

            // Turnos
            'ver turnos', 'crear turnos', 'editar turnos', 'eliminar turnos',

            // Usuarios
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

    }
}
