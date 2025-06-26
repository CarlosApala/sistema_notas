<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Usuarios del Sistema</h1>

        <!-- Mensaje de éxito -->
        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <!-- Botón Crear Nuevo Usuario -->
        <Link href="/sistema/usuarios/create"
            class="btn btn-success mb-3 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Crear Nuevo Usuario
        </Link>

        <!-- Tabla de usuarios -->
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Usuario</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">{{ user.name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ user.email }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ user.username }}</td>
                    <td class="border border-gray-300 px-4 py-2 space-x-2">
                        <Link :href="`/sistema/usuarios/${user.id}`"
                            class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Ver
                        </Link>
                        <Link :href="`/sistema/usuarios/${user.id}/edit`"
                            class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Editar
                        </Link>
                        <button @click="deleteUser(user.id)"
                            class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="mt-4 text-base text-gray-700 font-semibold border-t pt-3">
            <strong>Nota:</strong> Si actualizas los permisos, recarga la página para que se apliquen los cambios.
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Swal from 'sweetalert2'

import { Link, router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

// Props que envía Laravel (desde el controlador)
const props = defineProps({
    users: Array,
    flash: Object,
})

// Mostrar toast o alerta cuando flash.success cambie
watch(() => props.flash?.success, (msg) => {
    if (msg) {
        alert(msg) // Puedes reemplazar con una notificación mejor
    }
})

// Función para eliminar usuario
function deleteUser(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el usuario.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/usuarios/${id}`, {
                onSuccess: () => {
                    Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success')
                }
            })
        }
    })
}
</script>

<style scoped>
/* Puedes ajustar los estilos o usar Tailwind / Bootstrap según prefieras */

/* Opcional: estilos para los botones */
.btn {
    cursor: pointer;
    transition: background-color 0.2s ease;
}
</style>
