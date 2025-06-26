<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Predio</h1>

    <form
      @submit.prevent="submit"
      class="bg-white p-6 rounded shadow max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6"
    >
      <!-- Botón Cancelar arriba -->
      <div class="md:col-span-2 flex justify-end space-x-2 mb-4">
        <Link
          href="/sistema/predios"
          class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
        >
          Cancelar
        </Link>
      </div>

      <!-- Dirección ocupa 2 columnas -->
      <div class="md:col-span-2">
        <label for="direccion" class="block font-medium mb-1">Dirección</label>
        <input
          v-model="form.direccion"
          id="direccion"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
          required
        />
        <p v-if="errors.direccion" class="text-red-600 text-sm mt-1">
          {{ errors.direccion }}
        </p>
      </div>

      <!-- Ubicación GPS -->
      <div>
        <label for="ubicaciongps" class="block font-medium mb-1"
          >Ubicación GPS</label
        >
        <input
          v-model="form.ubicaciongps"
          id="ubicaciongps"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.ubicaciongps" class="text-red-600 text-sm mt-1">
          {{ errors.ubicaciongps }}
        </p>
      </div>

      <!-- Zona/Barrio con modal -->
      <div>
        <label for="zonaBarrio" class="block font-medium mb-1">Zona/Barrio</label>
        <input
          v-model="form.zonaBarrio"
          id="zonaBarrio"
          type="text"
          class="form-input w-full border rounded px-3 py-2 cursor-pointer"
          readonly
          @click="abrirModal"
          placeholder="Seleccione una zona"
        />
        <p v-if="errors.zonaBarrio" class="text-red-600 text-sm mt-1">
          {{ errors.zonaBarrio }}
        </p>
      </div>

      <!-- Resto de campos igual -->

      <div>
        <label for="distrito" class="block font-medium mb-1">Distrito</label>
        <input
          v-model="form.distrito"
          id="distrito"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.distrito" class="text-red-600 text-sm mt-1">
          {{ errors.distrito }}
        </p>
      </div>

      <div>
        <label for="UnidadVecinal" class="block font-medium mb-1"
          >Unidad Vecinal</label
        >
        <input
          v-model="form.UnidadVecinal"
          id="UnidadVecinal"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.UnidadVecinal" class="text-red-600 text-sm mt-1">
          {{ errors.UnidadVecinal }}
        </p>
      </div>

      <div>
        <label for="Manzana" class="block font-medium mb-1">Manzana</label>
        <input
          v-model="form.Manzana"
          id="Manzana"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.Manzana" class="text-red-600 text-sm mt-1">
          {{ errors.Manzana }}
        </p>
      </div>

      <div>
        <label for="AreaPredio" class="block font-medium mb-1"
          >Área Predio (m²)</label
        >
        <input
          v-model.number="form.AreaPredio"
          id="AreaPredio"
          type="number"
          step="0.01"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.AreaPredio" class="text-red-600 text-sm mt-1">
          {{ errors.AreaPredio }}
        </p>
      </div>

      <div>
        <label for="LongitudFrente" class="block font-medium mb-1"
          >Longitud Frente (m)</label
        >
        <input
          v-model.number="form.LongitudFrente"
          id="LongitudFrente"
          type="number"
          step="0.01"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.LongitudFrente" class="text-red-600 text-sm mt-1">
          {{ errors.LongitudFrente }}
        </p>
      </div>

      <div>
        <label for="AreaConstruida" class="block font-medium mb-1"
          >Área Construida (m²)</label
        >
        <input
          v-model.number="form.AreaConstruida"
          id="AreaConstruida"
          type="number"
          step="0.01"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.AreaConstruida" class="text-red-600 text-sm mt-1">
          {{ errors.AreaConstruida }}
        </p>
      </div>

      <div>
        <label for="NroHaitaciones" class="block font-medium mb-1"
          >Número Habitaciones</label
        >
        <input
          v-model.number="form.NroHaitaciones"
          id="NroHaitaciones"
          type="number"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.NroHaitaciones" class="text-red-600 text-sm mt-1">
          {{ errors.NroHaitaciones }}
        </p>
      </div>

      <div>
        <label for="NroPisos" class="block font-medium mb-1">Número Pisos</label>
        <input
          v-model.number="form.NroPisos"
          id="NroPisos"
          type="number"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.NroPisos" class="text-red-600 text-sm mt-1">
          {{ errors.NroPisos }}
        </p>
      </div>

      <div>
        <label for="NroGrifos" class="block font-medium mb-1">Número Grifos</label>
        <input
          v-model.number="form.NroGrifos"
          id="NroGrifos"
          type="number"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.NroGrifos" class="text-red-600 text-sm mt-1">
          {{ errors.NroGrifos }}
        </p>
      </div>

      <div>
        <label for="NroBaños" class="block font-medium mb-1">Número Baños</label>
        <input
          v-model.number="form.NroBaños"
          id="NroBaños"
          type="number"
          min="0"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.NroBaños" class="text-red-600 text-sm mt-1">
          {{ errors.NroBaños }}
        </p>
      </div>

      <div class="md:col-span-2">
        <label for="TipoEdificacion" class="block font-medium mb-1"
          >Tipo Edificación</label
        >
        <input
          v-model="form.TipoEdificacion"
          id="TipoEdificacion"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.TipoEdificacion" class="text-red-600 text-sm mt-1">
          {{ errors.TipoEdificacion }}
        </p>
      </div>

      <div class="flex items-center gap-6">
        <div class="flex items-center gap-2">
          <input
            v-model="form.Pavimento"
            id="Pavimento"
            type="checkbox"
            class="form-checkbox"
          />
          <label for="Pavimento" class="font-medium">Pavimento</label>
        </div>
        <div class="flex items-center gap-2">
          <input
            v-model="form.PredioHabitado"
            id="PredioHabitado"
            type="checkbox"
            class="form-checkbox"
          />
          <label for="PredioHabitado" class="font-medium">Predio Habitado</label>
        </div>
      </div>
      <p v-if="errors.Pavimento" class="text-red-600 text-sm mt-1 md:col-span-2">
        {{ errors.Pavimento }}
      </p>
      <p
        v-if="errors.PredioHabitado"
        class="text-red-600 text-sm mt-1 md:col-span-2"
      >
        {{ errors.PredioHabitado }}
      </p>

      <div class="md:col-span-2">
        <label for="EstadoEdificacion" class="block font-medium mb-1"
          >Estado Edificación</label
        >
        <input
          v-model="form.EstadoEdificacion"
          id="EstadoEdificacion"
          type="text"
          class="form-input w-full border rounded px-3 py-2"
        />
        <p v-if="errors.EstadoEdificacion" class="text-red-600 text-sm mt-1">
          {{ errors.EstadoEdificacion }}
        </p>
      </div>

      <div class="md:col-span-2">
        <label for="Observaciones" class="block font-medium mb-1"
          >Observaciones</label
        >
        <textarea
          v-model="form.Observaciones"
          id="Observaciones"
          rows="3"
          class="form-textarea w-full border rounded px-3 py-2"
        ></textarea>
        <p v-if="errors.Observaciones" class="text-red-600 text-sm mt-1">
          {{ errors.Observaciones }}
        </p>
      </div>

      <!-- Botón Guardar -->
      <div class="md:col-span-2 flex justify-end space-x-2">
        <button
          type="submit"
          class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-6 py-2"
          :disabled="processing"
        >
          <span v-if="processing" class="mr-2">
            <svg
              class="animate-spin h-5 w-5 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
              ></circle>
              <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
              ></path>
            </svg>
          </span>
          Guardar
        </button>
      </div>
    </form>

    <!-- Modal para selección de zonas -->
    <teleport to="body">
      <div v-if="modalVisible" class="modal-overlay" @click="cerrarModal"></div>
      <transition name="slide">
        <aside v-if="modalVisible" class="sidebar" @click.self="cerrarModal">
          <header class="sidebar-header flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Seleccione una Zona</h2>
            <button
              class="sidebar-close text-2xl font-bold px-2 py-0"
              @click="cerrarModal"
              aria-label="Cerrar modal"
            >
              &times;
            </button>
          </header>

          <div class="lista-zonas">
            <ul>
              <li
                v-for="zona in zonas"
                :key="zona.id"
                class="cursor-pointer hover:bg-blue-100 px-4 py-2 rounded"
                @click="seleccionarZona(zona.NombreZona)"
              >
                {{ zona.NombreZona }}
              </li>
            </ul>
          </div>
        </aside>
      </transition>
    </teleport>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  zonas: {
    type: Array,
    default: () => []
  }
})

const form = ref({
  direccion: '',
  ubicaciongps: '',
  zonaBarrio: '',
  distrito: '',
  UnidadVecinal: '',
  Manzana: '',
  AreaPredio: null,
  LongitudFrente: null,
  AreaConstruida: null,
  NroHaitaciones: null,
  NroPisos: null,
  NroGrifos: null,
  NroBaños: null,
  TipoEdificacion: '',
  Pavimento: false,
  EstadoEdificacion: '',
  PredioHabitado: false,
  Observaciones: ''
})

const errors = ref({})
const processing = ref(false)
const modalVisible = ref(false)

function abrirModal() {
  modalVisible.value = true
}

function cerrarModal() {
  modalVisible.value = false
}

function seleccionarZona(nombre) {
  form.value.zonaBarrio = nombre
  cerrarModal()
}

function submit() {
  processing.value = true
  errors.value = {}

  router.post('/sistema/predios', form.value, {
    onSuccess: () => {
      processing.value = false
    },
    onError: (err) => {
      processing.value = false
      errors.value = err
    }
  })
}
</script>

<style scoped>
.lista-zonas {
  max-height: 80vh;
  overflow-y: auto;
  padding-right: 0.5rem;
}

.sidebar {
  position: fixed;
  top: 0;
  right: 0;
  width: 40vw;
  max-width: 400px;
  height: 100vh;
  background: white;
  box-shadow: -2px 0 8px rgba(0, 0, 0, 0.15);
  padding: 1.5rem;
  overflow: hidden;
  z-index: 10000;
}

/* Modal overlay */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.3);
  z-index: 9999;
}

/* Transición lateral */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(100%);
}
</style>
