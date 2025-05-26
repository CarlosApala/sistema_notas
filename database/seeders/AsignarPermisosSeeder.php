<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AsignarPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     // Rol Admin - Todos los permisos
        $admin = Role::find(1);
        $admin->syncPermissions(Permission::all());

        // Rol Maestro
        $maestro = Role::find(2);
        $maestro->syncPermissions([
            'ver alumnos', 'crear alumnos', 'editar alumnos',
            'ver asistencias', 'crear asistencias', 'editar asistencias',
            'ver calificaciones', 'crear calificaciones', 'editar calificaciones',
            'ver cursos', 'crear cursos', 'editar cursos',
            'ver materias', 'crear materias', 'editar materias',
            'ver paralelos', 'crear paralelos', 'editar paralelos',
            'ver mensajes', 'crear mensajes', 'editar mensajes',
            'ver mensaje usuario', 'crear mensaje usuario', 'editar mensaje usuario',
            'ver usuarios', 'ver turnos'
        ]);

        // Rol Alumno
        $alumno = Role::find(3);
        $alumno->syncPermissions([
            'ver asistencias',
            'ver calificaciones',
            'ver cursos',
            'ver materias',
            'ver paralelos',
            'ver profesores',
            'ver mensajes',
            'ver mensaje usuario',
            'ver turnos'
        ]);
    }
}
