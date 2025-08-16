<template>
    <div class="container py-4">
        <h2 class="mb-4">Detalle de la Zona</h2>

        <div class="card p-4 mb-4">
            <h3>{{ zona.NombreZona }}</h3>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Rutas relacionadas</h5>
                <button class="btn btn-success btn-sm" @click="abrirModalRegistroRuta">Registrar Ruta</button>
            </div>

            <table v-if="zona.rutas.length" class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nombre de la Ruta</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ruta in zona.rutas" :key="ruta.id" class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ ruta.id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ ruta.NombreRuta }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                            <button class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                @click="abrirModalActualizarRuta(ruta)">
                                Actualizar
                            </button>
                            <button class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                @click="confirmarEliminacionRuta(ruta.id)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p v-else class="text-muted">No hay rutas asignadas a esta zona.</p>
        </div>


    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    zona: {
        type: Object,
        required: true
    }
})

function abrirModalRegistroRuta() {
    Swal.fire({
        title: 'Registrar Ruta',
        input: 'text',
        inputLabel: 'Nombre de la Ruta',
        inputPlaceholder: 'Ingrese el nombre',
        showCancelButton: true,
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) return 'El nombre es obligatorio'
        }
    }).then(result => {
        if (result.isConfirmed && result.value) {
            const form = useForm({
                NombreRuta: result.value,
                zona_id: props.zona.id
            })

            form.post('/nLecturaMovil/sistema/zonas_rutas', {
                onSuccess: () => {
                    Swal.fire('¡Registrado!', 'Ruta registrada correctamente.', 'success')
                    location.reload() // o mejor actualizar datos desde API si quieres SPA más fluida
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo registrar la ruta.', 'error')
                }
            })
        }
    })
}

function abrirModalActualizarRuta(ruta) {
    Swal.fire({
        title: 'Actualizar Ruta',
        input: 'text',
        inputLabel: 'Nombre de la Ruta',
        inputValue: ruta.NombreRuta,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) return 'El nombre es obligatorio'
        }
    }).then(result => {
        if (result.isConfirmed && result.value) {
            const form = useForm({
                NombreRuta: result.value,
                zona_id: props.zona.id
            })

            // Asumo que tu ruta de actualización es tipo PUT y recibe id en la url
            form.put(`/nLecturaMovil/sistema/zonas_rutas/actualizar-ruta/${ruta.id}`, {
                onSuccess: () => {
                    Swal.fire('¡Actualizado!', 'Ruta actualizada correctamente.', 'success')
                    location.reload()
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo actualizar la ruta.', 'error')
                }
            })
        }
    })
}

function confirmarEliminacionRuta(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la ruta.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({})
            form.delete(`/nLecturaMovil/sistema/zonas_rutas/delete-ruta/${id}`, {
                onSuccess: () => {
                    Swal.fire('Eliminado', 'La ruta ha sido eliminada.', 'success')
                    location.reload()
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo eliminar la ruta.', 'error')
                }
            })
        }
    })
}
</script>

<style scoped>
.container {
    max-width: 700px;
}

.me-2 {
    margin-right: 0.5rem;
}
</style>
