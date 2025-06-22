<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Registrar Nueva Instalación</h1>

    <form @submit.prevent="submit" class="max-w-2xl bg-white p-6 rounded shadow">
      <!-- Predio -->
      <div class="mb-4">
        <label for="predio" class="block font-medium mb-1">Predio</label>
        <select v-model="form.idPredio" id="predio" class="form-select w-full border rounded px-3 py-2">
          <option value="" disabled>Selecciona un predio</option>
          <option v-for="predio in predios" :key="predio.id" :value="predio.id">
            {{ predio.direccion }} - {{ predio.zonaBarrio }} ({{ predio.distrito }})
          </option>
        </select>
        <p v-if="errors.idPredio" class="text-red-600 text-sm mt-1">{{ errors.idPredio }}</p>
      </div>

      <!-- Campos simples -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block font-medium mb-1">Fecha de Instalación</label>
          <input type="date" v-model="form.FechaInstalacion" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.FechaInstalacion" class="text-red-600 text-sm mt-1">{{ errors.FechaInstalacion }}</p>
        </div>

        <div>
          <label class="block font-medium mb-1">Número de Medidor</label>
          <input type="text" v-model="form.NumeroMedidor" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.NumeroMedidor" class="text-red-600 text-sm mt-1">{{ errors.NumeroMedidor }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block font-medium mb-1">Estado de Instalación</label>
          <input type="text" v-model="form.EstadoInstalacion" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.EstadoInstalacion" class="text-red-600 text-sm mt-1">{{ errors.EstadoInstalacion }}</p>
        </div>
        <div>
          <label class="block font-medium mb-1">Estado de Alcantarillado</label>
          <input type="text" v-model="form.EstadoAlcantarillado" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.EstadoAlcantarillado" class="text-red-600 text-sm mt-1">{{ errors.EstadoAlcantarillado }}</p>
        </div>
      </div>

      <div class="mb-4">
        <label class="block font-medium mb-1">Observaciones</label>
        <textarea v-model="form.Observaciones" class="form-input w-full border rounded px-3 py-2"></textarea>
        <p v-if="errors.Observaciones" class="text-red-600 text-sm mt-1">{{ errors.Observaciones }}</p>
      </div>

      <!-- Grifos y Baños -->
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block font-medium mb-1">Nro Grifos</label>
          <input type="number" v-model="form.NroGrifos" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.NroGrifos" class="text-red-600 text-sm mt-1">{{ errors.NroGrifos }}</p>
        </div>
        <div>
          <label class="block font-medium mb-1">Nro Baños</label>
          <input type="number" v-model="form.NroBaños" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.NroBaños" class="text-red-600 text-sm mt-1">{{ errors.NroBaños }}</p>
        </div>
      </div>

      <!-- Corte, Promedio y Ubicación -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
          <label class="block font-medium mb-1">Estado Corte</label>
          <input type="text" v-model="form.EstadoCorte" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.EstadoCorte" class="text-red-600 text-sm mt-1">{{ errors.EstadoCorte }}</p>
        </div>
        <div>
          <label class="block font-medium mb-1">Promedio Consumo</label>
          <input type="number" step="0.01" v-model="form.PromedioConsumo" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.PromedioConsumo" class="text-red-600 text-sm mt-1">{{ errors.PromedioConsumo }}</p>
        </div>
        <div>
          <label class="block font-medium mb-1">Código Ubicación</label>
          <input type="text" v-model="form.CodigoUbicacion" class="form-input w-full border rounded px-3 py-2" />
          <p v-if="errors.CodigoUbicacion" class="text-red-600 text-sm mt-1">{{ errors.CodigoUbicacion }}</p>
        </div>
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
              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
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

const predios = ref([])
const form = ref({
  idPredio: '',
  FechaInstalacion: '',
  NumeroMedidor: '',
  EstadoInstalacion: '',
  EstadoAlcantarillado: '',
  Observaciones: '',
  NroGrifos: null,
  NroBaños: null,
  EstadoCorte: '',
  PromedioConsumo: null,
  CodigoUbicacion: '',
})

const errors = ref({})
const processing = ref(false)

onMounted(async () => {
  try {
    const res = await fetch('/api/predios')
    if (!res.ok) throw new Error('Error al cargar predios')
    predios.value = await res.json()
  } catch (e) {
    console.error('Error al cargar predios:', e)
  }
})

function submit() {
  processing.value = true
  errors.value = {}

  router.post('/sistema/instalaciones', form.value, {
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
