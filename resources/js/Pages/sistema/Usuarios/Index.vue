<template>
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4">Usuarios del Sistema</h1>


        <tabla-busqueda titulo="Lista de Usuarios" fetch-url="/nLecturaMovil/api/usuarios" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.name }}</td>
                <td class="p-2 border">{{ item.email }}</td>
                <td class="p-2 border">{{ item.username }}</td>
                <td class="p-2 border space-x-2">
                    <Link  :href="`/nLecturaMovil/sistema/usuarios/${item.id}`"
                        class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        @click.stop>
                    Ver
                    </Link>

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

console.log('mostrar datos');
console.log(permissions);
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
    router.visit(`/nLecturaMovil/sistema/usuarios/${user.id}`)
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
            router.delete(`/nLecturaMovil/sistema/usuarios/${id}`, {
                onSuccess: () => {
                    Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success')
                }
            })
        }
    })
}
</script>
