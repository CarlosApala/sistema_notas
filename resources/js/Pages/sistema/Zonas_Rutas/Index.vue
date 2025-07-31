<template>
    <div class="container py-4 max-w-5xl mx-auto">
        <div class="d-flex justify-content-between items-center mb-3">
            <h4 class="mb-0 text-xl font-semibold">Zonas y Rutas</h4>
            <button v-if="permissions.includes('zona.crear')" class="btn btn-success" @click="abrirModalRegistroZona">Registrar Zona</button>
        </div>

        <TablaBusqueda titulo="Lista de Zonas" fetch-url="/api/zonas_rutas" :columnas="columnas" :per-page="10"
            @onRowClick="() => { }">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.id }}</td>
                <td class="p-2 border">{{ item.NombreZona }}</td>
                <td class="p-2 border max-w-xs text-truncate" style="max-width: 200px;">
                    <span v-if="item.rutas?.length">
                        {{item.rutas.map(r => r.NombreRuta).join(' - ')}}
                    </span>
                    <span v-else class="text-gray-500 italic">Sin rutas registradas</span>
                </td>
                <td class="p-2 border text-center space-x-2">
                    <Link  class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        :href="`/sistema/zonas_rutas/${item.id}`" @click.stop>
                    Ver más
                    </Link>
                    <button v-if="permissions.includes('zona.eliminar')" class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        @click.stop="confirmarEliminacion(item.id)">
                        Eliminar
                    </button>
                </td>
            </template>
        </TablaBusqueda>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'
import { usePage } from '@inertiajs/vue3'


const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []
    defineOptions({ layout: AppLayout })

const columnas = [
    { key: 'id', label: '#' },
    { key: 'NombreZona', label: 'Zona' },
    { key: 'rutas', label: 'Rutas' },
    // La columna acciones no va en columnas porque la ponemos en slot
]

// Función para registrar nueva zona con modal
function abrirModalRegistroZona() {
    Swal.fire({
        title: 'Registrar Zona',
        input: 'text',
        inputLabel: 'Nombre de la Zona',
        inputPlaceholder: 'Ingrese el nombre',
        showCancelButton: true,
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => !value && 'El nombre es obligatorio',
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const form = useForm({ NombreZona: result.value })

            form.post('/sistema/zonas', {
                onSuccess: () => {
                    Swal.fire('¡Registrado!', 'Zona registrada correctamente.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo registrar la zona.', 'error')
                },
            })
        }
    })
}

// Confirmación para eliminar zona
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la zona y sus rutas relacionadas.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({})
            form.delete(`/sistema/zonas/${id}`, {
                onSuccess: () => {
                    Swal.fire('Eliminado', 'La zona ha sido eliminada.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo eliminar la zona.', 'error')
                },
            })
        }
    })
}
</script>

<style scoped>
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
