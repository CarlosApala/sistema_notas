<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Zonas y Rutas</h4>
            <button class="btn btn-success" @click="abrirModalRegistroZona">Registrar Zona</button>
        </div>

        <!-- Filtro de búsqueda -->
        <div class="mb-3 d-flex gap-2">
            <input v-model="filters.search" type="text" class="form-control" placeholder="Buscar por nombre de zona" />
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">#</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Zona</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Rutas</th>
                    <th class="border border-gray-300 px-4 py-2 text-left text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="zona in zonas.data" :key="zona.id" class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">{{ zona.id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ zona.NombreZona }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-truncate max-w-xs" style="max-width: 200px;">
                        <span v-if="zona.rutas?.length">
                            {{zona.rutas.map(r => r.NombreRuta).join(' - ')}}
                        </span>
                        <span class="text-gray-500 italic" v-else>Sin rutas registradas</span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                        <Link
                            class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                            :href="`/sistema/zonas_rutas/${zona.id}`">
                        Ver más
                        </Link>
                        <button
                            class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                            @click="confirmarEliminacion(zona.id)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>



        <!-- Paginación -->
        <nav class="mt-3" v-if="zonas.links?.length">
            <ul class="pagination justify-content-center">
                <li v-for="(link, index) in zonas.links" :key="index"
                    :class="['page-item', { active: link.active, disabled: !link.url }]">
                    <Link v-if="link.url" class="page-link" :href="link.url" preserve-scroll :data="filters"
                        v-html="link.label" />
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue'
import { useForm, router, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    zonas: Object,
    filters: Object,
})

const filters = reactive({
    search: props.filters?.search || '',
})

// Watch con debounce para búsqueda automática
let timeout = null
watch(() => filters.search, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get('/sistema/zonas_rutas', { ...filters }, {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        })
    }, 250)
})

function abrirModalRegistroZona() {
    Swal.fire({
        title: 'Registrar Zona',
        input: 'text',
        inputLabel: 'Nombre de la Zona',
        inputPlaceholder: 'Ingrese el nombre',
        showCancelButton: true,
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar',
        inputValidator: value => !value && 'El nombre es obligatorio'
    }).then(result => {
        if (result.isConfirmed && result.value) {
            const form = useForm({ NombreZona: result.value })

            form.post('/sistema/zonas', {
                onSuccess: () => {
                    Swal.fire('¡Registrado!', 'Zona registrada correctamente.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo registrar la zona.', 'error')
                }
            })
        }
    })
}

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la zona y sus rutas relacionadas.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({})
            form.delete(`/sistema/zonas/${id}`, {
                onSuccess: () => {
                    Swal.fire('Eliminado', 'La zona ha sido eliminada.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo eliminar la zona.', 'error')
                }
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
