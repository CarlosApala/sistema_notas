<template>
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4">Usuarios del Sistema</h1>

        <Link v-if="permissions.includes('usuarios.create')" href="/sistema/usuarios/create"
            class="btn btn-success mb-3 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Crear Nuevo Usuario
        </Link>

        <tabla-busqueda titulo="Lista de Usuarios" fetch-url="/api/usuarios" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.name }}</td>
                <td class="p-2 border">{{ item.email }}</td>
                <td class="p-2 border">{{ item.username }}</td>
                <td class="p-2 border space-x-2">
                    <Link v-if="permissions.includes('usuarios.view')" :href="`/sistema/usuarios/${item.id}`"
                        class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        @click.stop>
                    Ver
                    </Link>
                    <Link v-if="permissions.includes('usuarios.edit')" :href="`/sistema/usuarios/${item.id}/edit`"
                        class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        @click.stop>
                    Editar
                    </Link>
                    <button v-if="permissions.includes('usuarios.delete')" @click.stop="deleteUser(item.id)"
                        class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </td>
            </template>
        </tabla-busqueda>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

defineOptions({ layout: App })
const columnas = [
    { key: 'name', label: 'Nombre' },
    { key: 'email', label: 'Email' },
    { key: 'username', label: 'Usuario' },
    // La columna acciones la vamos a manejar manualmente, no aquí
]

// Manejo del clic en fila, si quieres navegar o mostrar detalles
function handleRowClick(user) {
    // Por ejemplo, ir a la vista detalle del usuario:
    router.visit(`/sistema/usuarios/${user.id}`)
}

// Función para eliminar usuario (podrías hacer un botón externo o un slot en tablaBusqueda si soporta)
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
