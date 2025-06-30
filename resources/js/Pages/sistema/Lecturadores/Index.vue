<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Asignaciones para Lecturador
            <span v-if="filters.deleted">(eliminados)</span>
        </h1>

        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <form @submit.prevent="buscar" class="d-flex gap-2 flex-wrap">
                <input v-model="filters.search" type="text" placeholder="Buscar por periodo o usuario..."
                    class="form-control" />
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <Link v-if="permissions.includes('asignaciones.create')"  href="/sistema/lecturadores/create" class="btn btn-success">
                Asignar Ruta
                </Link>

                <Link v-if="permissions.includes('asignaciones.view_deleted')" :href="filters.deleted ? '/sistema/lecturadores' : '/sistema/lecturadores?deleted=true'"
                    class="btn btn-secondary">
                {{ filters.deleted ? 'Ver Activos' : 'Ver Eliminados' }}
                </Link>
            </div>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nombre Ruta</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Usuario</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Periodo</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="asignacion in asignaciones.data" :key="asignacion.id" class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">{{ asignacion.id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ asignacion.ruta?.NombreRuta || '-'
                    }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ asignacion.usuario?.name || '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ asignacion.periodo || '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                        <template v-if="filters.deleted && permissions.includes('asignaciones.restore')">
                            <button @click="restaurar(asignacion.id)"
                                class="btn btn-success btn-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                Restaurar
                            </button>
                        </template>
                        <template v-else >
                            <Link v-if="permissions.includes('asignaciones.view')" :href="`/sistema/lecturadores/${asignacion.id}`"
                                class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Ver
                            </Link>
                            <Link v-if="permissions.includes('asignaciones.edit')" :href="`/sistema/lecturadores/${asignacion.id}/edit`"
                                class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Editar
                            </Link>
                            <button v-if="permissions.includes('asignaciones.delete')" @click="eliminar(asignacion.id)"
                                class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Eliminar
                            </button>
                        </template>
                    </td>
                </tr>

                <tr v-if="asignaciones.data.length === 0">
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No se encontraron asignaciones.
                    </td>
                </tr>
            </tbody>
        </table>




        <!-- Paginación -->
        <nav class="mt-4 flex justify-center">
            <ul class="pagination">
                <li v-for="(link, index) in asignaciones.links" :key="index"
                    :class="['page-item', { disabled: !link.url, active: link.active }]">
                    <a v-if="link.url" href="#" class="page-link" @click.prevent="paginar(link.url)"
                        v-html="link.label"></a>
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>

    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []
defineOptions({ layout: App })

const { asignaciones, filters: initialFilters, flash } = defineProps({
    asignaciones: Object,
    filters: Object,
    flash: Object,
})


const filters = ref({ ...initialFilters })

let timeout = null
watch(() => filters.value.search, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get('/sistema/lecturadores', filters.value, {
            preserveState: true,
            replace: true,
        })
    }, 500)
})


function buscar() {
    router.get('/sistema/lecturadores', filters.value, {
        preserveState: true,
        replace: true,
    })
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la asignación',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/lecturadores/${id}`, {
                preserveState: true,
            })
        }
    })
}

function restaurar(id) {
    Swal.fire({
        title: '¿Restaurar asignación?',
        text: '¿Estás seguro que deseas restaurar esta asignación?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/sistema/lecturadores/${id}/restore`, {}, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Restaurado',
                        text: 'La asignación ha sido restaurada correctamente.',
                        icon: 'success',
                    }).then(() => {
                        // Opcionalmente recargas para que se actualice la lista
                        router.get('/sistema/lecturadores', {}, {
                            preserveState: false,
                            replace: true,
                        })
                    })
                },
                onError: () => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al restaurar la asignación.',
                        icon: 'error',
                    })
                }
            })
        }
    })
}


function paginar(url) {
    router.get(url, {}, { preserveState: true, replace: true })
}
</script>


<style scoped>
/* Puedes agregar tus estilos si quieres */
</style>
