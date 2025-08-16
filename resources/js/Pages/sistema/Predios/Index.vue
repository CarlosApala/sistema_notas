<template>
    <div class="container mx-auto p-4 max-w-5xl">


        <div v-if="flash.success" class="alert alert-success mb-4">{{ flash.success }}</div>

        <div class="mb-4 flex flex-wrap gap-2 justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">
                Lista de los Predios <span v-if="filters.deleted">(eliminados)</span>
            </h1>
            <div class="flex gap-2 flex-wrap" >
                <Link v-if="permissions.includes('predios.crear')" href="/nLecturaMovil/sistema/predios/create" class="btn btn-success">Registrar Predio</Link>
                <button v-if="permissions.includes('predios.eliminar')" @click="toggleDeleted" class="btn btn-secondary">
                    {{ filters.deleted ? 'Ver Activos' : 'Ver Eliminados' }}
                </button>
            </div>
        </div>

        <TablaBusqueda :key="fetchUrl" :titulo="'Lista de Predios'" :fetch-url="fetchUrl" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.id }}</td>
                <td class="p-2 border">{{ item.direccion }}</td>
                <td class="p-2 border">{{ item.zonaBarrio }}</td>
                <td class="p-2 border">{{ item.distrito }}</td>

                <td class="p-2 border text-center space-x-2">
                    <button v-if="filters.deleted && permissions.includes('predios.restaurar')" @click.stop="restaurar(item.id)" class="btn btn-success btn-sm">
                        Restaurar
                    </button>
                    <template v-else>
                        <Link  :href="`/nLecturaMovil/sistema/predios/${item.id}`" class="btn btn-info btn-sm">Ver</Link>
                        <Link v-if="permissions.includes('predios.editar')" :href="`/nLecturaMovil/sistema/predios/${item.id}/edit`" class="btn btn-warning btn-sm">Editar</Link>
                        <button v-if="permissions.includes('predios.eliminar')" @click.stop="eliminar(item.id)" class="btn btn-danger btn-sm">Eliminar</button>
                    </template>
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
  const url = new URL('/nLecturaMovil/api/predios', window.location.origin)

  if (filters.value.deleted) url.searchParams.append('deleted', 'true')
  if (busqueda.value) url.searchParams.append('search', busqueda.value)
  url.searchParams.append('per_page', '10')

  return url.toString()
})

// Columnas para la tabla
const columnas = [
  { key: 'id', label: 'ID' },
  { key: 'direccion', label: 'Dirección' },
  { key: 'zonaBarrio', label: 'Zona/Barrio' },
  { key: 'distrito', label: 'Distrito' },
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
    url: '/nLecturaMovil/sistema/predios',
    data: { ...newFilters },
    preserveState: true,
  })
})

function toggleDeleted() {
  filters.value.deleted = !filters.value.deleted
  busqueda.value = ''
}

function handleRowClick(item) {
  router.visit(`/nLecturaMovil/sistema/predios/${item.id}`)
}

function eliminar(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción eliminará el predio.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/nLecturaMovil/sistema/predios/${id}`, { preserveState: true })
    }
  })
}

function restaurar(id) {
  Swal.fire({
    title: '¿Restaurar predio?',
    text: '¿Estás seguro que deseas restaurar este predio?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, restaurar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(
        `/nLecturaMovil/sistema/predios/${id}/restore`,
        {},
        {
          preserveState: true,
          onSuccess: () => {
            Swal.fire('Restaurado', 'El predio ha sido restaurado correctamente.', 'success')
            // Actualizar la página forzando recarga de listado
            router.get(
              '/nLecturaMovil/sistema/predios',
              {
                deleted: true,
                search: filters.value.search || '',
              },
              {
                preserveState: true,
                replace: true,
              }
            )
          },
          onError: () => {
            Swal.fire('Error', 'Ocurrió un error al restaurar el predio.', 'error')
          },
        }
      )
    }
  })
}
</script>
