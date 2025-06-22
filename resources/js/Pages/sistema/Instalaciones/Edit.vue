<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Editar Instalación</h1>

    <div v-if="loading" class="flex justify-center items-center h-40">
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

      <form @submit.prevent="submit" class="bg-white p-6 rounded shadow max-w-3xl mx-auto space-y-6">
        <div>
          <label for="idPredio" class="block font-medium mb-1">Predio</label>
          <select v-model="form.idPredio" id="idPredio" class="form-select w-full border rounded px-3 py-2" required>
            <option value="" disabled>Selecciona un predio</option>
            <option v-for="predio in predios" :key="predio.id" :value="predio.id">
              {{ predio.direccion }} - {{ predio.zonaBarrio }} - {{ predio.distrito }}
            </option>
          </select>
        </div>

        <div>
          <label for="FechaInstalacion" class="block font-medium mb-1">Fecha Instalación</label>
          <input type="date" id="FechaInstalacion" v-model="form.FechaInstalacion" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="NumeroMedidor" class="block font-medium mb-1">Número Medidor</label>
          <input type="text" id="NumeroMedidor" v-model="form.NumeroMedidor" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="EstadoInstalacion" class="block font-medium mb-1">Estado Instalación</label>
          <input type="text" id="EstadoInstalacion" v-model="form.EstadoInstalacion" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="EstadoAlcantarillado" class="block font-medium mb-1">Estado Alcantarillado</label>
          <input type="text" id="EstadoAlcantarillado" v-model="form.EstadoAlcantarillado" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="Observaciones" class="block font-medium mb-1">Observaciones</label>
          <textarea id="Observaciones" v-model="form.Observaciones" rows="3" class="form-textarea w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="NroGrifos" class="block font-medium mb-1">Número de Grifos</label>
            <input type="number" id="NroGrifos" v-model.number="form.NroGrifos" min="0" class="form-input w-full border rounded px-3 py-2" />
          </div>

          <div>
            <label for="NroBanos" class="block font-medium mb-1">Número de Baños</label>
            <input type="number" id="NroBanos" v-model.number="form.NroBanos" min="0" class="form-input w-full border rounded px-3 py-2" />
          </div>
        </div>

        <div>
          <label for="EstadoCorte" class="block font-medium mb-1">Estado Corte</label>
          <input type="text" id="EstadoCorte" v-model="form.EstadoCorte" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="PromedioConsumo" class="block font-medium mb-1">Promedio Consumo</label>
          <input type="number" id="PromedioConsumo" v-model.number="form.PromedioConsumo" step="0.01" min="0" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label for="CodigoUbicacion" class="block font-medium mb-1">Código Ubicación</label>
          <input type="text" id="CodigoUbicacion" v-model="form.CodigoUbicacion" class="form-input w-full border rounded px-3 py-2" />
        </div>

        <div class="flex justify-between items-center pt-4">
          <router-link href="/sistema/instalaciones" class="btn btn-secondary px-4 py-2 rounded">
            Cancelar
          </router-link>

          <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2"
            :disabled="processing">
            {{ processing ? 'Actualizando...' : 'Actualizar Instalación' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router, Link as routerLink } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  instalacion: Object
})

const predios = ref([])
const loading = ref(true)
const processing = ref(false)
const errors = ref({})

const form = ref({
  idPredio: props.instalacion.idPredio || '',
  FechaInstalacion: props.instalacion.FechaInstalacion || '',
  NumeroMedidor: props.instalacion.NumeroMedidor || '',
  EstadoInstalacion: props.instalacion.EstadoInstalacion || '',
  EstadoAlcantarillado: props.instalacion.EstadoAlcantarillado || '',
  Observaciones: props.instalacion.Observaciones || '',
  NroGrifos: props.instalacion.NroGrifos ?? null,
  NroBanos: props.instalacion.NroBanos ?? null,
  EstadoCorte: props.instalacion.EstadoCorte || '',
  PromedioConsumo: props.instalacion.PromedioConsumo ?? null,
  CodigoUbicacion: props.instalacion.CodigoUbicacion || '',
})

async function loadPredios() {
  loading.value = true
  try {
    const res = await fetch('/api/predios')
    predios.value = await res.json()
  } catch (error) {
    Swal.fire('Error', 'No se pudo cargar la lista de predios.', 'error')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPredios()
})

async function submit() {
  const result = await Swal.fire({
    title: '¿Actualizar instalación?',
    text: '¿Estás seguro que quieres guardar los cambios?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, actualizar',
    cancelButtonText: 'Cancelar',
  })

  if (!result.isConfirmed) return

  processing.value = true
  errors.value = {}

  router.put(`/sistema/instalaciones/${props.instalacion.id}`, form.value, {
    onSuccess: () => {
      processing.value = false
      Swal.fire('Actualizado', 'La instalación se ha actualizado correctamente.', 'success').then(() => {
        router.get('/sistema/instalaciones')
      })
    },
    onError: (err) => {
      processing.value = false
      errors.value = err
      Swal.fire('Error', 'Hubo un problema al actualizar la instalación.', 'error')
    },
  })
}
</script>

<style scoped>
.form-input,
.form-select,
.form-textarea {
  outline: none;
  transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  border-color: #2563eb;
}
</style>
