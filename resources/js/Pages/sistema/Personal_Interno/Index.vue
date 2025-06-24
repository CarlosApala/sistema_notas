<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">
      Personal Interno
      <span v-if="filters.deleted">(eliminados)</span>
    </h1>

    <div v-if="flash.success" class="alert alert-success mb-4">
      {{ flash.success }}
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <form @submit.prevent="buscar" class="d-flex gap-2 flex-wrap">
        <input v-model="filters.search" type="text" placeholder="Buscar por nombre, apellido o CI..."
          class="form-control" />
        <button type="submit" class="btn btn-primary">Buscar</button>
      </form>

      <div class="flex gap-2 flex-wrap">
        <Link href="/sistema/personal_interno/create" class="btn btn-success">
          Nuevo Personal
        </Link>

        <Link :href="filters.deleted ? '/sistema/personal_interno' : '/sistema/personal_interno?deleted=true'"
          class="btn btn-secondary">
          {{ filters.deleted ? 'Ver Activos' : 'Ver Eliminados' }}
        </Link>
      </div>
    </div>

    <!-- Contenedor con scroll horizontal -->
    <div class="overflow-x-auto">
      <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 60px;">ID</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 180px;">Nombres</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 180px;">Apellidos</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 120px;">Carnet Identidad</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 130px;">Fecha Nacimiento</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 140px;">Nacionalidad</th>
            <th class="border border-gray-300 px-4 py-2 text-left" style="max-width: 140px;">Número Celular</th>
            <th class="border border-gray-300 px-4 py-2 text-center" style="min-width: 210px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="persona in personalInterno.data" :key="persona.id" class="hover:bg-gray-100">
            <td class="border border-gray-300 px-4 py-2">{{ persona.id }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.nombres }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.apellidos }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.carnet_identidad || '-' }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.fecha_nacimiento || '-' }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.nacionalidad || '-' }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ persona.numero_celular || '-' }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center space-x-2 whitespace-nowrap">
              <template v-if="filters.deleted">
                <button @click="restaurar(persona.id)"
                  class="btn btn-success btn-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                  Restaurar
                </button>
              </template>
              <template v-else>
                <Link :href="`/sistema/personal_interno/${persona.id}`"
                  class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                  Ver
                </Link>
                <Link :href="`/sistema/personal_interno/${persona.id}/edit`"
                  class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                  Editar
                </Link>
                <button @click="eliminar(persona.id)"
                  class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                  Eliminar
                </button>
              </template>
            </td>
          </tr>

          <tr v-if="personalInterno.data.length === 0">
            <td colspan="8" class="text-center p-4 text-gray-500">
              No se encontraron registros.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <nav class="mt-4 flex justify-center">
      <ul class="pagination">
        <li v-for="(link, index) in personalInterno.links" :key="index"
          :class="['page-item', { disabled: !link.url, active: link.active }]">
          <a v-if="link.url" href="#" class="page-link" @click.prevent="paginar(link.url)" v-html="link.label"></a>
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

defineOptions({ layout: App })

const { personalInterno: initialPersonal, filters: initialFilters, flash } = defineProps({
  personalInterno: Object,
  filters: Object,
  flash: Object,
})

const filters = ref({ ...initialFilters })

let timeout = null
watch(() => filters.value.search, () => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    router.get('/sistema/personal_interno', filters.value, {
      preserveState: true,
      replace: true,
    })
  }, 500)
})

function buscar() {
  router.get('/sistema/personal_interno', filters.value, {
    preserveState: true,
    replace: true,
  })
}

function eliminar(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción eliminará el registro',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/sistema/personal_interno/${id}`, {
        preserveState: true,
      })
    }
  })
}

function restaurar(id) {
  Swal.fire({
    title: '¿Restaurar registro?',
    text: '¿Estás seguro que deseas restaurar este registro?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, restaurar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(`/sistema/personal_interno/${id}/restore`, {}, {
        preserveState: true,
        onSuccess: () => {
          Swal.fire({
            title: 'Restaurado',
            text: 'El registro ha sido restaurado correctamente.',
            icon: 'success',
          }).then(() => {
            // Aquí recargamos la vista de eliminados
            router.get('/sistema/personal_interno', { deleted: true }, {
              preserveState: false,
              replace: true,
            })
          })
        },
        onError: () => {
          Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al restaurar el registro.',
            icon: 'error',
          })
        }
      })
    }
  })
}


function paginar(url) {
  try {
    const u = new URL(url, window.location.origin)
    const relative = u.pathname + u.search
    router.get(relative, {}, { preserveState: true, replace: true })
  } catch (e) {
    console.error("Error al parsear URL de paginación:", url)
  }
}


</script>

<style scoped>
table th,
table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

table th {
  /* Opcional: para que las cabeceras se ajusten igual */
  max-width: none;
}

</style>
