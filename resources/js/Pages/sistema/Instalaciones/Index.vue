<template>
    <div class="container mx-auto p-4 max-w-5xl">


        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <div class="mb-4 flex flex-wrap gap-2 justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">
                Instalaciones
                <span v-if="filters.deleted">(eliminadas)</span>
            </h1>
            <div class="flex gap-2 flex-wrap">
                <Link v-if="permissions.includes('instalaciones.crear')" href="/sistema/instalaciones/create" class="btn btn-success">Nueva Instalación</Link>
                <button v-if="permissions.includes('instalaciones.eliminar')" @click="toggleDeleted" class="btn btn-secondary">
                    {{ filters.deleted ? 'Ver Activas' : 'Ver Eliminadas' }}
                </button>
            </div>
        </div>

        <TablaBusqueda :titulo="'Lista de Instalaciones'" :fetch-url="fetchUrl" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.id }}</td>
                <td class="p-2 border">{{ item.NumeroMedidor }}</td>
                <td class="p-2 border">{{ item.CodigoUbicacion }}</td>
                <td class="p-2 border">{{ item.EstadoInstalacion }}</td>
                <td class="p-2 border">{{ item.EstadoAlcantarillado }}</td>
                <td class="p-2 border text-center space-x-2">
                    <button v-if="permissions.includes('instalaciones.restaurar')" @click.stop="restaurar(item.id)"
                        class="btn btn-success btn-sm px-3 py-1">
                        Restaurar
                    </button>
                    <template v-else>
                        <Link v-if="permissions.includes('instalaciones.ver')" :href="`/sistema/instalaciones/${item.id}`" class="btn btn-info btn-sm px-3 py-1">
                        Ver
                        </Link>
                        <Link v-if="permissions.includes('instalaciones.editar')" :href="`/sistema/instalaciones/${item.id}/edit`" class="btn btn-warning btn-sm px-3 py-1">
                        Editar
                        </Link>
                        <button v-if="permissions.includes('instalaciones.eliminar')" @click.stop="eliminar(item.id)" class="btn btn-danger btn-sm px-3 py-1">
                            Eliminar
                        </button>
                    </template>
                </td>
            </template>
        </TablaBusqueda>
    </div>
</template>
<script setup>
import { ref, computed, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

defineOptions({ layout: App })

const props = defineProps({
    filters: Object,
    flash: Object,
})

const filters = ref({ ...props.filters })
const busqueda = ref(filters.value.search || '')

// Computed para armar URL de fetch según filtros
const fetchUrl = computed(() => {
    const url = new URL('/api/instalaciones', window.location.origin)
    if (filters.value.deleted) url.searchParams.append('deleted', 'true')
    if (busqueda.value) url.searchParams.append('search', busqueda.value)
    url.searchParams.append('per_page', '10')
    return url.toString()
})

const columnas = [
    { key: 'id', label: 'ID' },
    { key: 'NumeroMedidor', label: 'Medidor' },
    { key: 'CodigoUbicacion', label: 'Código Ubicación' },
    { key: 'EstadoInstalacion', label: 'Estado Instalación' },
    { key: 'EstadoAlcantarillado', label: 'Alcantarillado' },

]

// Como Vue no soporta keys con punto directo, usaremos un helper para mostrar predio.direccion:
function getValueByPath(obj, path) {
    return path.split('.').reduce((o, i) => (o ? o[i] : ''), obj)
}

// Para mostrar en tabla-busqueda, modificamos el slot para que muestre predio.direccion:
// En TablaBusqueda.vue dentro del <template v-for="col in columnas"> en el td:
//   - si la key incluye punto: usar getValueByPath(item, col.key)

// Búsqueda con debounce
let timeout = null
watch(busqueda, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        filters.value.search = busqueda.value
    }, 500)
})

watch(filters, (newFilters) => {
    router.replace({
        url: '/sistema/instalaciones',
        data: { ...newFilters },
        preserveState: true,
    })
})

function buscar() {
    filters.value.search = busqueda.value
}

function toggleDeleted() {
    filters.value.deleted = !filters.value.deleted
    busqueda.value = ''
}

function handleRowClick(item) {
    router.visit(`/sistema/instalaciones/${item.id}`)
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la instalación.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/instalaciones/${id}`, { preserveState: true })
        }
    })
}

function restaurar(id) {
    Swal.fire({
        title: '¿Restaurar instalación?',
        text: '¿Estás seguro que deseas restaurarla?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/sistema/instalaciones/${id}/restore`, {}, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire('Restaurada', 'La instalación ha sido restaurada.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo restaurar la instalación.', 'error')
                }
            })
        }
    })
}
</script>
