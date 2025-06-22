<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Editar Personal Interno</h1>

    <div v-if="loading" class="flex justify-center items-center h-40">
      <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
      </svg>
    </div>

    <div v-else>
      <div v-if="Object.keys(errors).length" class="alert alert-danger mb-4">
        <ul>
          <li v-for="(msg, key) in errors" :key="key">{{ msg }}</li>
        </ul>
      </div>

      <form @submit.prevent="submit" class="bg-white p-6 rounded shadow max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="nombres" class="block font-medium mb-1">Nombres</label>
          <input
            v-model="form.nombres"
            id="nombres"
            type="text"
            class="form-input w-full border rounded px-3 py-2"
            required
          />
        </div>

        <div>
          <label for="apellidos" class="block font-medium mb-1">Apellidos</label>
          <input
            v-model="form.apellidos"
            id="apellidos"
            type="text"
            class="form-input w-full border rounded px-3 py-2"
            required
          />
        </div>

        <div>
          <label for="carnet_identidad" class="block font-medium mb-1">Carnet de Identidad</label>
          <input
            v-model="form.carnet_identidad"
            id="carnet_identidad"
            type="text"
            class="form-input w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="fecha_nacimiento" class="block font-medium mb-1">Fecha de Nacimiento</label>
          <input
            v-model="form.fecha_nacimiento"
            id="fecha_nacimiento"
            type="date"
            class="form-input w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="nacionalidad" class="block font-medium mb-1">Nacionalidad</label>
          <input
            v-model="form.nacionalidad"
            id="nacionalidad"
            type="text"
            class="form-input w-full border rounded px-3 py-2"
          />
        </div>

        <div>
          <label for="numero_celular" class="block font-medium mb-1">Número de Celular</label>
          <input
            v-model="form.numero_celular"
            id="numero_celular"
            type="tel"
            class="form-input w-full border rounded px-3 py-2"
          />
        </div>

        <div class="md:col-span-2 flex justify-between">
          <router-link href="/sistema/personal_interno" class="btn btn-secondary">
            Volver atrás
          </router-link>

          <button
            type="submit"
            class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-6 py-2"
            :disabled="processing"
          >
            {{ processing ? 'Actualizando...' : 'Actualizar' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link as routerLink } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  personal: Object
})

const loading = ref(false)
const processing = ref(false)
const errors = ref({})

const form = ref({
  nombres: props.personal.nombres || '',
  apellidos: props.personal.apellidos || '',
  carnet_identidad: props.personal.carnet_identidad || '',
  fecha_nacimiento: props.personal.fecha_nacimiento || '',
  nacionalidad: props.personal.nacionalidad || '',
  numero_celular: props.personal.numero_celular || '',
})

function submit() {
  Swal.fire({
    title: '¿Actualizar personal?',
    text: '¿Estás seguro que deseas guardar los cambios?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, actualizar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      processing.value = true
      errors.value = {}

      router.put(`/sistema/personal_interno/${props.personal.id}`, form.value, {
        onSuccess: () => {
          processing.value = false
          Swal.fire('Actualizado', 'El personal interno ha sido actualizado correctamente.', 'success').then(() => {
            router.get('/sistema/personal_interno')
          })
        },
        onError: (err) => {
          processing.value = false
          errors.value = err
          Swal.fire('Error', 'Hubo un problema al actualizar.', 'error')
        },
      })
    }
  })
}
</script>

<style scoped>
.form-input {
  outline: none;
  transition: border-color 0.2s;
}

.form-input:focus {
  border-color: #2563eb;
}
</style>
