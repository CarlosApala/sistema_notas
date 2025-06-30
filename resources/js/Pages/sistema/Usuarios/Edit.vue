<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>

        <div v-if="Object.keys(errors).length"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <li v-for="(msg, key) in errors" :key="key">{{ msg }}</li>
            </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-1 font-medium" for="name">Nombre</label>
                    <input v-model="form.name" type="text" id="name" class="w-full border rounded px-3 py-2" required />
                </div>

                <div>
                    <label class="block mb-1 font-medium" for="email">Correo Electrónico</label>
                    <input v-model="form.email" type="email" id="email" class="w-full border rounded px-3 py-2"
                        required />
                </div>

                <div>
                    <label class="block mb-1 font-medium" for="username">Nombre de Usuario</label>
                    <input v-model="form.username" type="text" id="username" class="w-full border rounded px-3 py-2"
                        required />
                </div>

                <div>
                    <label class="block mb-1 font-medium" for="password">Nueva Contraseña (opcional)</label>
                    <input v-model="form.password" type="password" id="password"
                        class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block mb-1 font-medium" for="password_confirmation">Confirmar Contraseña</label>
                    <input v-model="form.password_confirmation" type="password" id="password_confirmation"
                        class="w-full border rounded px-3 py-2" />
                </div>
            </div>

            <hr />

            <div>
                <h4 class="font-bold mb-2">Roles</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="role in rolesDisponibles" :key="role.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'role_' + role.id" :value="role.name" v-model="form.roles"
                            class="form-check-input" />
                        <label :for="'role_' + role.id" class="form-check-label">{{ role.name }}</label>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-2">Permisos de Usuarios</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in usuariosPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-2">Permisos de Personal Interno</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in personalInternoPermisos" :key="permiso.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>

                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-2">Permisos de Lecturadores</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in lecturadoresPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>

                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-2">Permisos de Zonas</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in zonaPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-2">Permisos de Predios</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in prediosPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-2">Permisos de Instalaciones</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in instalacionesPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>
                    </div>
                </div>
            </div>



            <div>
                <h4 class="font-bold mb-2">Permisos de Asignaciones</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div v-for="permiso in asignacionesPermisos" :key="permiso.id" class="flex items-center space-x-2">
                        <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name"
                            v-model="form.permisos" class="form-check-input" />
                        <label :for="'permiso_' + permiso.id" class="form-check-label">
                            {{ permissionLabels[permiso.name] || permiso.name }}
                        </label>
                    </div>
                </div>
            </div>




            <div class="flex justify-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    :disabled="form.processing">
                    Actualizar
                </button>
                <Link href="/sistema/usuarios"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm, usePage, Link, router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import Swal from 'sweetalert2'
import { permissionLabels } from '@/utils/permissionLabels'


defineOptions({ layout: App })

const page = usePage()

const usuario = page.props.usuario
const rolesDisponibles = page.props.rolesDisponibles || []
const permisosDisponibles = page.props.permisosDisponibles || []
const rolesUsuario = page.props.rolesUsuario || []
const permisosUsuarioDirectos = page.props.permisosUsuarioDirectos || []
const errors = page.props.errors || {}

const form = useForm({
    name: usuario.name || '',
    email: usuario.email || '',
    username: usuario.username || '',
    password: '',
    password_confirmation: '',
    roles: [...rolesUsuario],
    permisos: [...permisosUsuarioDirectos],
})

// Filtra solo permisos lecturadores
const lecturadoresPermisos = permisosDisponibles.filter(p =>
    [
        'lecturadores.view',
        'lecturadores.show',
        'lecturadores.create',
        'lecturadores.edit',
        'lecturadores.delete',
        'lecturadores.view_deleted',
        'lecturadores.restore',
    ].includes(p.name)
)
const zonaPermisos = permisosDisponibles.filter(p =>
    [
        'zona.index',
        'zona.ver',
        'zona.crear',
        'zona.editar',
        'zona.eliminar',
        'zona.restaurar',
    ].includes(p.name)
)
const usuariosPermisos = permisosDisponibles.filter(p =>
    [
        'usuarios.view',
        'usuarios.show',
        'usuarios.create',
        'usuarios.edit',
        'usuarios.delete',
        'usuarios.view_deleted',
        'usuarios.restore',
    ].includes(p.name)
)


const instalacionesPermisos = permisosDisponibles.filter(p =>
    [
        'instalaciones.index',
        'instalaciones.ver',
        'instalaciones.crear',
        'instalaciones.editar',
        'instalaciones.eliminar',
        'instalaciones.restaurar',
    ].includes(p.name)
)
const asignacionesPermisos = permisosDisponibles.filter(p =>
    [
        'asignaciones.view',
        'asignaciones.show',
        'asignaciones.create',
        'asignaciones.edit',
        'asignaciones.delete',
        'asignaciones.view_deleted',
        'asignaciones.restore',
    ].includes(p.name)
)



const prediosPermisos = permisosDisponibles.filter(p =>
    [
        'predios.index',
        'predios.ver',
        'predios.crear',
        'predios.editar',
        'predios.eliminar',
        'predios.restaurar',
    ].includes(p.name)
)


// Aquí va la variable filtrada con los permisos específicos:
const personalInternoPermisos = permisosDisponibles.filter(p =>
    [
        'personal_interno.view',
        'personal_interno.show',
        'personal_interno.create',
        'personal_interno.edit',
        'personal_interno.delete',
        'personal_interno.view_deleted',
        'personal_interno.restore',
    ].includes(p.name)
)

function submit() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas guardar los cambios de este usuario?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            form.put(route('usuarios.update', usuario.id), {
                onSuccess: () => {
                    Swal.fire('Actualizado', 'El usuario ha sido actualizado correctamente.', 'success').then(() => {
                        router.visit(window.location.pathname, { preserveState: false, preserveScroll: true })
                    })

                },
            })
        }
    })
}
</script>


<style scoped>
/* Ajusta estilos si quieres */
</style>
