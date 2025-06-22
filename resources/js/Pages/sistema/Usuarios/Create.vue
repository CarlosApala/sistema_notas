<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Crear Nuevo Usuario</h1>

    <div v-if="Object.keys(errors).length" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <ul>
        <li v-for="(msg, key) in errors" :key="key">{{ msg }}</li>
      </ul>
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      <!-- Datos personales -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Nombre</label>
          <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Correo Electrónico</label>
          <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Nombre de Usuario</label>
          <input v-model="form.username" type="text" class="w-full border rounded px-3 py-2" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Contraseña</label>
          <input v-model="form.password" type="password" class="w-full border rounded px-3 py-2" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Confirmar Contraseña</label>
          <input v-model="form.password_confirmation" type="password" class="w-full border rounded px-3 py-2" required />
        </div>
      </div>

      <!-- Roles -->
      <div>
        <label class="block font-bold mb-2">Roles</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
          <div v-for="role in roles" :key="role.id" class="flex items-center space-x-2">
            <input type="checkbox" :id="'role_' + role.id" :value="role.name" v-model="form.roles" />
            <label :for="'role_' + role.id">{{ role.name }}</label>
          </div>
        </div>
      </div>

      <!-- Permisos -->
      <div>
        <label class="block font-bold mb-2">Permisos Directos</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
          <div v-for="permiso in permisos" :key="permiso.id" class="flex items-center space-x-2">
            <input type="checkbox" :id="'permiso_' + permiso.id" :value="permiso.name" v-model="form.permisos" />
            <label :for="'permiso_' + permiso.id">{{ permiso.name }}</label>
          </div>
        </div>
      </div>

      <!-- Botón de envío -->
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          Crear Usuario
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'

const successMessage = ref('')
defineOptions({ layout: App })

const page = usePage()
const roles = page.props.roles
const permisos = page.props.permisos
const errors = page.props.errors || {}

const form = useForm({
  name: '',
  email: '',
  username: '',
  password: '',
  password_confirmation: '',
  roles: [],
  permisos: [],
})

function submit() {
     console.log(form);
  form.post(route('usuarios.store'), {
    onSuccess: () => {
      successMessage.value = 'Usuario guardado exitosamente.'
      form.reset() // opcional, para limpiar el formulario
    },
    onError: () => {
      successMessage.value = ''
    }
  })
}
</script>
