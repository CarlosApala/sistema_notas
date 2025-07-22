<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>

        <form @submit.prevent="submit">
            <!-- Datos básicos -->
            <div class="card border rounded p-4 mb-4">
                <div class="mb-2">
                    <strong>Email:</strong>
                    <input type="email" v-model="form.email" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Usuario:</strong>
                    <input type="text" v-model="form.username" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Nombre:</strong>
                    <input type="text" v-model="form.name" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Contraseña:</strong>
                    <input type="password" v-model="form.password" class="input" />
                </div>
                <div class="mb-2">
                    <strong>Confirmar contraseña:</strong>
                    <input type="password" v-model="form.password_confirmation" class="input" />
                </div>
            </div>

            <!-- Tabla de permisos -->
            <h4 class="font-semibold mb-2">Permisos asignados:</h4>
            <TablaPermisosPorModulo v-model="form.permisos" :estructura="estructuraModulos" :acciones="acciones" />




            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Actualizar Usuario
                </button>
            </div>


        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import TablaPermisosPorModulo from '@/Components/TablaPermisosPorModulo.vue'

defineOptions({ layout: App })

const props = defineProps({
    usuario: Object,
    rolesDisponibles: Array,
    permisosDisponibles: Array,
    rolesUsuario: Array,
    permisosUsuarioDirectos: Array,
})

const form = reactive({
    name: props.usuario.name,
    email: props.usuario.email,
    username: props.usuario.username,
    password: '',
    password_confirmation: '',
    roles: [...props.rolesUsuario],
    permisos: [...props.permisosUsuarioDirectos],
})

function submit() {
    router.put(route('usuarios.update', props.usuario.id), form)
}

const acciones = ['ver', 'crear', 'editar', 'eliminar', 'eliminados', 'restaurar']

const estructuraModulos = {
    'Gestión': {
        'Usuarios': 'usuarios',
        'Personal Interno': 'personal_interno',
        'Lecturadores': 'lecturadores',
        'Zona': 'zona',
        'Predios': 'predios',
        'Instalaciones': 'instalaciones',
        'Asignaciones': 'asignaciones'
    }
}
</script>

<style scoped>
.input {
    width: 100%;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.bg-gray-100 {
    background-color: #f7fafc;
}

.container {
    max-width: 900px;
}

.card {
    background-color: white;
}

.table-auto th,
.table-auto td {
    border: 1px solid #ddd;
    padding: 6px 10px;
}
</style>
