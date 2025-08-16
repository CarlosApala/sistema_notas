<template>
    <div class="container mx-auto p-4 max-w-5xl">

        <div v-if="flash.success" class="alert alert-success mb-4">{{ flash.success }}</div>

        <div class="mb-4 flex flex-wrap gap-2 justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">
                Lista de las Zonas <span v-if="filters.deleted">(eliminadas)</span>
            </h1>
            <div class="flex gap-2 flex-wrap">
                <Link v-if="permissions.includes('zonas.crear')" href="/nLecturaMovil/sistema/zonas/create" class="btn btn-success">
                Registrar Zona
                </Link>
                <button v-if="permissions.includes('zonas.eliminar')" @click="toggleDeleted" class="btn btn-secondary">
                    {{ filters.deleted ? 'Ver Activas' : 'Ver Eliminadas' }}
                </button>
            </div>
        </div>

        <TablaBusqueda :key="fetchUrl" :titulo="'Lista de Zonas'" :fetch-url="fetchUrl" :columnas="columnas"
            :per-page="10" @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.id }}</td>
                <td class="p-2 border">{{ item.NombreZona }}</td>

                <td class="p-2 border text-center space-x-2">
                    <Link :href="`/nLecturaMovil/sistema/zonas/${item.id}`" class="btn btn-info btn-sm">
                    Ver
                    </Link>
                    <button class="btn btn-warning btn-sm" @click="editarZonaSwal(item)">
                        Editar
                    </button>

                    <!-- <Link :href="`/nLecturaMovil/sistema/zonas/${item.id}/edit`" class="btn btn-warning btn-sm">Editar</Link> -->

                </td>
            </template>
        </TablaBusqueda>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
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

// Computed para generar la URL de la API con los parámetros actuales
const fetchUrl = computed(() => {
    const url = new URL('/nLecturaMovil/api/zonas', window.location.origin)

    if (filters.value.deleted) url.searchParams.append('deleted', 'true')
    if (busqueda.value) url.searchParams.append('search', busqueda.value)
    url.searchParams.append('per_page', '10')

    return url.toString()
})

// Columnas para la tabla de zonas
const columnas = [
    { key: 'id', label: 'ID' },
    { key: 'NombreZona', label: 'Nombre de Zona' },
]

// Debounce para búsqueda: actualiza filtros.search 500ms después de cambiar la búsqueda
let timeout = null
watch(busqueda, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        filters.value.search = busqueda.value
    }, 500)
})

// Cuando cambien los filtros, actualiza la URL con replace para mantener estado y sincronizar rutas
watch(filters, (newFilters) => {
    router.replace({
        url: '/nLecturaMovil/sistema/zonas',
        data: { ...newFilters },
        preserveState: true,
    })
})

function toggleDeleted() {
    filters.value.deleted = !filters.value.deleted
    busqueda.value = ''
}

function handleRowClick(item) {
    router.visit(`/nLecturaMovil/sistema/zonas/${item.id}`)
}

async function editarZonaSwal(item) {
    const { value: nuevoNombre } = await Swal.fire({
        title: 'Editar Zona',
        input: 'text',
        inputLabel: 'Nombre de la Zona',
        inputValue: item.NombreZona,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            if (!value) return 'El nombre no puede estar vacío'
        },
    })

    if (nuevoNombre && nuevoNombre !== item.NombreZona) {
        router.put(`/nLecturaMovil/sistema/zonas/${item.id}`, {
            NombreZona: nuevoNombre,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                fetchUrl();
                Swal.fire('Actualizado', 'El nombre de la zona ha sido actualizado.', 'success')
            },
            onError: () => {
                Swal.fire('Error', 'No se pudo actualizar la zona.', 'error')
            }
        })
    }
}



</script>
