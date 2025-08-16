<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Editar Asignación de Ruta a Lecturador</h1>

    <div v-if="loading" class="flex justify-center items-center h-40">
      <!-- Spinner simple mientras carga -->
      <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
        </path>
      </svg>
    </div>

    <div v-else>
      <div v-if="Object.keys(errors).length" class="alert alert-danger mb-4">
        <ul>
          <li v-for="(msg, key) in errors" :key="key">{{ msg }}</li>
        </ul>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Formulario -->
        <form @submit.prevent="submit" class="bg-white p-6 rounded shadow">
          <div class="mb-4">
            <label for="idRuta" class="block font-medium mb-1">Ruta de Instalación</label>
            <select v-model="form.idRuta" id="idRuta" class="form-select w-full border rounded px-3 py-2" required>
              <option value="" disabled>Selecciona una ruta</option>
              <option v-for="ruta in rutas" :key="ruta.id" :value="ruta.id">
                {{ ruta.ruta?.NombreRuta || 'Ruta #' + ruta.id }} - {{ ruta.nInstalacion }}
              </option>
            </select>
          </div>

          <div class="mb-4">
            <label for="idUser" class="block font-medium mb-1">Lecturador</label>
            <select v-model="form.idUser" id="idUser" class="form-select w-full border rounded px-3 py-2" required>
              <option value="" disabled>Selecciona un usuario</option>
              <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                {{ usuario.name }} ({{ usuario.email }})
              </option>
            </select>
          </div>

          <div class="mb-6">
            <label for="periodo" class="block font-medium mb-1">Período</label>
            <input type="text" id="periodo" v-model="form.periodo" class="form-input w-full border rounded px-3 py-2" required />
          </div>

          <div class="flex justify-between">
            <Link href="/nLecturaMovil/sistema/lecturadores" class="btn btn-secondary">
              Volver atrás
            </Link>

            <button type="submit"
              class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2"
              :disabled="processing">
              {{ processing ? 'Actualizando...' : 'Actualizar Asignación' }}
            </button>
          </div>
        </form>

        <!-- Información seleccionada -->
        <div>
          <h5 class="font-semibold mb-2">Información Seleccionada</h5>

          <div v-if="selectedRuta">
            <table class="table-auto border-collapse border border-gray-300 mb-4 w-full">
              <tbody>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 text-left">Nombre Ruta</th>
                  <td class="border border-gray-300 px-4 py-2">{{ selectedRuta.ruta?.NombreRuta || 'N/A' }}</td>
                </tr>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 text-left">Número Instalación</th>
                  <td class="border border-gray-300 px-4 py-2">{{ selectedRuta.nInstalacion || 'N/A' }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div v-if="selectedUsuario">
            <table class="table-auto border-collapse border border-gray-300 mb-4 w-full">
              <tbody>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 text-left">Nombre Lecturador</th>
                  <td class="border border-gray-300 px-4 py-2">{{ selectedUsuario.name || 'N/A' }}</td>
                </tr>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                  <td class="border border-gray-300 px-4 py-2">{{ selectedUsuario.email || 'N/A' }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div v-if="form.periodo.trim() !== ''">
            <table class="table-auto border-collapse border border-gray-300 w-full">
              <tbody>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 text-left">Período</th>
                  <td class="border border-gray-300 px-4 py-2">{{ form.periodo }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  asignacion: Object
})

const rutas = ref([])
const usuarios = ref([])
const loading = ref(true)

const form = ref({
  idRuta: props.asignacion.idRuta,
  idUser: props.asignacion.idUser,
  periodo: props.asignacion.periodo || '',
})

const errors = ref({})
const processing = ref(false)

const selectedRuta = computed(() => {
  return rutas.value.find(r => r.id === form.value.idRuta) || null
})

const selectedUsuario = computed(() => {
  return usuarios.value.find(u => u.id === form.value.idUser) || null
})

async function loadData() {
  loading.value = true
  try {
    const [rutasRes, usuariosRes] = await Promise.all([
      fetch('/nLecturaMovil/api/rutas'),
      fetch('/nLecturaMovil/api/usuarios')
    ])
    rutas.value = await rutasRes.json()
    usuarios.value = await usuariosRes.json()
  } catch (error) {
    Swal.fire('Error', 'No se pudo cargar la información.', 'error')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadData()
})

async function submit() {
  const result = await Swal.fire({
    title: '¿Actualizar asignación?',
    text: '¿Estás seguro que quieres guardar los cambios?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, actualizar',
    cancelButtonText: 'Cancelar',
  })

  if (result.isConfirmed) {
    processing.value = true
    errors.value = {}

    router.put(`/nLecturaMovil/sistema/lecturadores/${props.asignacion.id}`, form.value, {
      onSuccess: () => {
        processing.value = false
        Swal.fire('Actualizado', 'La asignación se ha actualizado correctamente.', 'success')
          .then(() => {
            router.get('/nLecturaMovil/sistema/lecturadores')  // <-- Aquí la redirección
          })
      },
      onError: (err) => {
        processing.value = false
        errors.value = err
        Swal.fire('Error', 'Hubo un problema al actualizar la asignación.', 'error')
      },
    })
  }
}



</script>

<style scoped>
.form-input,
.form-select {
  outline: none;
  transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus {
  border-color: #2563eb;
}
</style>
