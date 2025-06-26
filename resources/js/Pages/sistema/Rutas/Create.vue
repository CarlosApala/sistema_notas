<!-- resources/js/Pages/Sistema/Rutas/Create.vue -->
<template>
  <div class="container py-4">
    <h4>Registrar Ruta</h4>

    <!-- ZONAS DISPONIBLES -->
    <div v-if="!zonaSeleccionada" class="card p-3 shadow-sm mb-4">
      <div class="mb-3">
        <button @click="volverZonaRutas" class="btn btn-secondary mb-3">
          Volver a Zonas – Rutas
        </button>
      </div>

      <h5>Selecciona una zona</h5>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Zona</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="zona in zonas.data" :key="zona.id">
            <td>{{ zona.id }}</td>
            <td>{{ zona.NombreZona }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="elegirZona(zona)">
                Elegir
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginación -->
      <nav class="mt-3">
        <ul class="pagination justify-content-center">
          <li v-for="(link, index) in zonas.links" :key="index"
              :class="['page-item', { active: link.active, disabled: !link.url }]">
            <a v-if="link.url" href="#" class="page-link" @click.prevent="cargarZonas(link.url)" v-html="link.label"></a>
            <span v-else class="page-link" v-html="link.label"></span>
          </li>
        </ul>
      </nav>
    </div>

    <!-- FORMULARIO DE RUTA -->
    <div v-else class="card p-3 shadow-sm">
      <div class="mb-3">
        <label class="form-label">Zona Seleccionada</label>
        <input type="text" class="form-control" :value="zonaSeleccionada.NombreZona" disabled>
      </div>

      <div class="mb-3">
        <label class="form-label">Nombre de la Ruta</label>
        <input v-model="form.NombreRuta" type="text" class="form-control"
               :class="{ 'is-invalid': form.errors.NombreRuta }">
        <div class="invalid-feedback" v-if="form.errors.NombreRuta">{{ form.errors.NombreRuta }}</div>
      </div>

      <div class="flex justify-start space-x-2">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded me-2"
                @click="submit">
          Registrar Ruta
        </button>
        <button type="button"
                class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                @click="cancelar">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const zonas = ref({ data: [], links: [] })
const zonaSeleccionada = ref(null)

const form = useForm({
  NombreRuta: '',
  zona_id: null,
})

onMounted(() => {
  cargarZonas()
})

async function cargarZonas(linkUrl = '/sistema/zonas') {
  try {
    const urlObj = new URL(linkUrl, window.location.origin)
    const finalUrl = urlObj.pathname + urlObj.search

    const res = await fetch(finalUrl, { credentials: 'include' })
    if (!res.ok) throw new Error('Error al cargar zonas')
    zonas.value = await res.json()
  } catch (error) {
    console.error('Error al cargar zonas:', error)
  }
}

function elegirZona(zona) {
  zonaSeleccionada.value = zona
  form.zona_id = zona.id
}

function submit() {
  form.post('/sistema/rutas', {
    onSuccess: () => {
      form.reset()
      zonaSeleccionada.value = null
      cargarZonas()
    }
  })
}

// Cancela el formulario y vuelve a la selección de zonas
function cancelar() {
  form.reset()
  zonaSeleccionada.value = null
}

// Volver a la página principal zonas_rutas
function volverZonaRutas() {
  router.visit('/sistema/zonas_rutas')
}
</script>
