<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle del Usuario</h1>

    <div class="card border rounded p-4 mb-4">
      <h5 class="text-xl font-semibold mb-2">{{ user.name }}</h5>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Usuario:</strong> {{ user.username }}</p>
      <p>
        <strong>Verificado:</strong>
        <span v-if="user.email_verified_at">{{ formatDate(user.email_verified_at) }}</span>
        <span v-else>No verificado</span>
      </p>
      <p><strong>Creado:</strong> {{ formatDate(user.created_at) }}</p>
      <p><strong>Actualizado:</strong> {{ formatDate(user.updated_at) }}</p>

      <hr class="my-4" />

      <h4 class="font-semibold mb-2">Roles asignados:</h4>
      <div v-if="user.roles.length === 0">
        <p>Este usuario no tiene roles asignados.</p>
      </div>
      <ul v-else class="list-disc ml-5 mb-4">
        <li v-for="rol in user.roles" :key="rol.id">{{ rol.name }}</li>
      </ul>

      <h4 class="font-semibold mb-2">Permisos del usuario (directos e indirectos):</h4>
      <div v-if="permisosUsuario.length === 0">
        <p>Este usuario no tiene permisos asignados.</p>
      </div>
      <ul v-else class="list-disc ml-5 mb-4">
        <li v-for="permiso in permisosUsuario" :key="permiso">{{ permiso }}</li>
      </ul>

      <h4 class="font-semibold mb-2">Permisos agrupados por rol:</h4>
      <div v-if="Object.keys(permisosPorRol).length === 0">
        <p>No hay permisos asignados por rol.</p>
      </div>
      <div v-else>
        <div v-for="(permisos, rol) in permisosPorRol" :key="rol" class="mb-3">
          <strong>Rol: {{ rol }}</strong>
          <ul class="list-disc ml-5">
            <li v-for="permiso in permisos" :key="permiso">{{ permiso }}</li>
          </ul>
        </div>
      </div>
    </div>

    <Link href="/sistema/usuarios" class="btn btn-secondary">Volver</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  user: Object,
  permisosUsuario: Array,
  permisosPorRol: Object,
})

// Función para formatear fechas (asumiendo ISO 8601)
// Ajusta según tu zona horaria y formato deseado
function formatDate(dateString) {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleString('es-BO', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  })
}
</script>

<style scoped>
.btn-secondary {
  @apply inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700;
}
</style>
