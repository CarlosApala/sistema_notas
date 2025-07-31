<template>
    <div class="container mx-auto p-4 max-w-5xl">


        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <div class="mb-4 flex flex-wrap gap-2 justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">
                Instalaciones

            </h1>

        </div>

        <TablaBusqueda :key="fetchUrl" :titulo="'Lista de Instalaciones'" :fetch-url="fetchUrl" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
            <template #row="{ item }">
                <td class="p-2 border">{{ item.id }}</td>
                <td class="p-2 border">{{ item.NumeroMedidor }}</td>
                <td class="p-2 border">{{ item.CodigoUbicacion }}</td>
                <td class="p-2 border">{{ item.EstadoInstalacion }}</td>
                <td class="p-2 border">{{ item.EstadoAlcantarillado }}</td>
                <td class="p-2 border text-center space-x-2">

                        <Link  :href="`/sistema/instalaciones/${item.id}`" class="btn btn-info btn-sm px-3 py-1">
                        Ver
                        </Link>
                        <Link v-if="permissions.includes('instalaciones.editar')" :href="`/sistema/instalaciones/${item.id}/edit`" class="btn btn-warning btn-sm px-3 py-1">
                        Editar
                        </Link>


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

// Generar URL para la API según filtros actuales
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

// Debounce para búsqueda
let timeout = null
watch(busqueda, () => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    filters.value.search = busqueda.value
  }, 500)
})

// Al cambiar filtros, sincronizamos URL con replace para no recargar y mantener estado
watch(filters, (newFilters) => {
  router.replace({
    url: '/sistema/instalaciones',
    data: { ...newFilters },
    preserveState: true,
  })
})

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
          // Opcional: forzar recarga de listado, por ejemplo
          router.get('/sistema/instalaciones', {
            deleted: true,
            search: filters.value.search || '',
          }, { preserveState: true, replace: true })
        },
        onError: () => {
          Swal.fire('Error', 'No se pudo restaurar la instalación.', 'error')
        }
      })
    }
  })
}
</script>
