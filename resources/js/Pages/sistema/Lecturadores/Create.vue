<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Asignar Ruta</h1>

    <!-- Formulario sin condición de carga -->
    <form @submit.prevent="submit" class="max-w-lg bg-white p-6 rounded shadow">
      <div class="mb-4">
        <label for="ruta" class="block font-medium mb-1">Ruta</label>
        <select v-model="form.idRuta" id="ruta" class="form-select w-full border rounded px-3 py-2">
          <option value="" disabled>Selecciona una ruta</option>
          <option v-for="ruta in rutas" :key="ruta.id" :value="ruta.id">
            {{ ruta.ruta?.NombreRuta }} - {{ ruta.nInstalacion }}
          </option>
        </select>
        <p v-if="errors.idRuta" class="text-red-600 text-sm mt-1">{{ errors.idRuta }}</p>
      </div>

      <div class="mb-4">
        <label for="usuario" class="block font-medium mb-1">Usuario</label>
        <select v-model="form.idUser" id="usuario" class="form-select w-full border rounded px-3 py-2">
          <option value="" disabled>Selecciona un usuario</option>
          <option v-for="user in usuarios" :key="user.id" :value="user.id">
            {{ user.name }} ({{ user.email }})
          </option>
        </select>
        <p v-if="errors.idUser" class="text-red-600 text-sm mt-1">{{ errors.idUser }}</p>
      </div>

      <div class="mb-6">
        <label for="periodo" class="block font-medium mb-1">Periodo</label>
        <input
          v-model="form.periodo"
          type="text"
          id="periodo"
          class="form-input w-full border rounded px-3 py-2"
          placeholder="Ejemplo: 2024-06"
        />
        <p v-if="errors.periodo" class="text-red-600 text-sm mt-1">{{ errors.periodo }}</p>
      </div>

      <button
        type="submit"
        class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2 flex items-center justify-center"
        :disabled="processing"
      >
        <span v-if="processing" class="mr-2">
          <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
            </path>
          </svg>
        </span>
        Guardar
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const rutas = ref([])
const usuarios = ref([])
const loading = ref(true)

const form = ref({
  idRuta: '',
  idUser: '',
  periodo: '',
})

const errors = ref({})
const processing = ref(false)

async function loadData() {
  loading.value = true
  try {
    const [rutasRes, usuariosRes] = await Promise.all([
      fetch('/api/rutas'),
      fetch('/api/usuarios')
    ])

    if (!rutasRes.ok || !usuariosRes.ok) {
      throw new Error('Error al cargar datos')
    }

    rutas.value = await rutasRes.json()
    usuarios.value = await usuariosRes.json()
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadData()
})

function submit() {
  processing.value = true
  errors.value = {}

  router.post('/sistema/lecturadores', form.value, {
    onSuccess: () => {
      processing.value = false
    },
    onError: (err) => {
      processing.value = false
      errors.value = err
    },
  })
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
