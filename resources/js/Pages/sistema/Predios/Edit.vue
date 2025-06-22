<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Editar Predio</h1>

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

      <form @submit.prevent="submit" class="bg-white p-6 rounded shadow max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
        <!-- Primera columna -->
        <div>
          <label for="direccion" class="block font-medium mb-1">Dirección</label>
          <input
            v-model="form.direccion"
            id="direccion"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
            required
          />
        </div>

        <div>
          <label for="ubicaciongps" class="block font-medium mb-1">Ubicación GPS</label>
          <input
            v-model="form.ubicaciongps"
            id="ubicaciongps"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="zonaBarrio" class="block font-medium mb-1">Zona/Barrio</label>
          <input
            v-model="form.zonaBarrio"
            id="zonaBarrio"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="distrito" class="block font-medium mb-1">Distrito</label>
          <input
            v-model="form.distrito"
            id="distrito"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="UnidadVecinal" class="block font-medium mb-1">Unidad Vecinal</label>
          <input
            v-model="form.UnidadVecinal"
            id="UnidadVecinal"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="Manzana" class="block font-medium mb-1">Manzana</label>
          <input
            v-model="form.Manzana"
            id="Manzana"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Segunda columna -->
        <div>
          <label for="AreaPredio" class="block font-medium mb-1">Área Predio (m²)</label>
          <input
            v-model.number="form.AreaPredio"
            id="AreaPredio"
            type="number"
            step="0.01"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="LongitudFrente" class="block font-medium mb-1">Longitud Frente (m)</label>
          <input
            v-model.number="form.LongitudFrente"
            id="LongitudFrente"
            type="number"
            step="0.01"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="AreaConstruida" class="block font-medium mb-1">Área Construida (m²)</label>
          <input
            v-model.number="form.AreaConstruida"
            id="AreaConstruida"
            type="number"
            step="0.01"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="NroHaitaciones" class="block font-medium mb-1">Número Habitaciones</label>
          <input
            v-model.number="form.NroHaitaciones"
            id="NroHaitaciones"
            type="number"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="NroPisos" class="block font-medium mb-1">Número Pisos</label>
          <input
            v-model.number="form.NroPisos"
            id="NroPisos"
            type="number"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="NroGrifos" class="block font-medium mb-1">Número Grifos</label>
          <input
            v-model.number="form.NroGrifos"
            id="NroGrifos"
            type="number"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="NroBaños" class="block font-medium mb-1">Número Baños</label>
          <input
            v-model.number="form.NroBaños"
            id="NroBaños"
            type="number"
            min="0"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Checkbox Pavimento -->
        <div class="flex items-center gap-3">
          <input
            v-model="form.Pavimento"
            id="Pavimento"
            type="checkbox"
            class="form-checkbox"
          />
          <label for="Pavimento" class="font-medium">Pavimento</label>
        </div>

        <!-- Checkbox Predio Habitado -->
        <div class="flex items-center gap-3">
          <input
            v-model="form.PredioHabitado"
            id="PredioHabitado"
            type="checkbox"
            class="form-checkbox"
          />
          <label for="PredioHabitado" class="font-medium">Predio Habitado</label>
        </div>

        <div>
          <label for="TipoEdificacion" class="block font-medium mb-1">Tipo Edificación</label>
          <input
            v-model="form.TipoEdificacion"
            id="TipoEdificacion"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="EstadoEdificacion" class="block font-medium mb-1">Estado Edificación</label>
          <input
            v-model="form.EstadoEdificacion"
            id="EstadoEdificacion"
            type="text"
            class="form-input w-4/5 max-w-full border rounded px-3 py-2"
          />
        </div>

        <!-- Observaciones (textarea) -->
        <div class="md:col-span-2">
          <label for="Observaciones" class="block font-medium mb-1">Observaciones</label>
          <textarea
            v-model="form.Observaciones"
            id="Observaciones"
            rows="3"
            class="form-textarea w-full border rounded px-3 py-2"
          ></textarea>
        </div>

        <div class="md:col-span-2 flex justify-between">
          <router-link href="/sistema/predios" class="btn btn-secondary">
            Volver atrás
          </router-link>

          <button
            type="submit"
            class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2"
            :disabled="processing"
          >
            {{ processing ? 'Actualizando...' : 'Actualizar Predio' }}
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
  predio: Object
})

const loading = ref(false)
const processing = ref(false)
const errors = ref({})

const form = ref({
  direccion: props.predio.direccion || '',
  ubicaciongps: props.predio.ubicaciongps || '',
  zonaBarrio: props.predio.zonaBarrio || '',
  distrito: props.predio.distrito || '',
  UnidadVecinal: props.predio.UnidadVecinal || '',
  Manzana: props.predio.Manzana || '',
  AreaPredio: props.predio.AreaPredio || null,
  LongitudFrente: props.predio.LongitudFrente || null,
  AreaConstruida: props.predio.AreaConstruida || null,
  NroHaitaciones: props.predio.NroHaitaciones || null,
  NroPisos: props.predio.NroPisos || null,
  NroGrifos: props.predio.NroGrifos || null,
  NroBaños: props.predio.NroBaños || null,
  TipoEdificacion: props.predio.TipoEdificacion || '',
  Pavimento: props.predio.Pavimento || false,
  EstadoEdificacion: props.predio.EstadoEdificacion || '',
  PredioHabitado: props.predio.PredioHabitado || false,
  Observaciones: props.predio.Observaciones || '',
})

function submit() {
  Swal.fire({
    title: '¿Actualizar predio?',
    text: '¿Estás seguro que quieres guardar los cambios?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, actualizar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      processing.value = true
      errors.value = {}

      router.put(`/sistema/predios/${props.predio.id}`, form.value, {
        onSuccess: () => {
          processing.value = false
          Swal.fire('Actualizado', 'El predio se ha actualizado correctamente.', 'success').then(() => {
            router.get('/sistema/predios')
          })
        },
        onError: (err) => {
          processing.value = false
          errors.value = err
          Swal.fire('Error', 'Hubo un problema al actualizar el predio.', 'error')
        },
      })
    }
  })
}
</script>


<style scoped>
.form-input,
.form-textarea,
.form-checkbox {
  outline: none;
  transition: border-color 0.2s;
}

.form-input:focus,
.form-textarea:focus {
  border-color: #2563eb;
}

.form-checkbox {
  width: 1.25rem;
  height: 1.25rem;
}
</style>
