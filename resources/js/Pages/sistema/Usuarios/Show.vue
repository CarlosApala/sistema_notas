<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle del Usuario</h1>

    <div class="card border rounded p-4 mb-4">
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Usuario:</strong> {{ user.username }}</p>
      <p>
        <strong>Verificado:</strong>
        <span v-if="user.email_verified_at">{{ formatDate(user.email_verified_at) }}</span>
        <span v-else>No verificado</span>
      </p>
      <p><strong>Creado:</strong> {{ formatDate(user.created_at) }}</p>
      <p><strong>Actualizado:</strong> {{ formatDate(user.updated_at) }}</p>
    </div>

    <h4 class="font-semibold mb-2">Permisos asignados:</h4>
    <div v-if="!permisosUsuario || permisosUsuario.length === 0">
      <p>Este usuario no tiene permisos asignados.</p>
    </div>
    <div v-else class="overflow-x-auto">
      <TablaPermisosPorModulo
        :estructura="estructuraModulos"
        :modelValue="permisosUsuario"
        :bloqueado="true"
      />
    </div>
  </div>
</template>

<script setup>
import App from '@/Layouts/AppLayout.vue'
import TablaPermisosPorModulo from '@/Components/TablaPermisosPorModulo.vue'

defineOptions({ layout: App })

const props = defineProps({
  user: Object,
  permisosUsuario: Array,
  permisosPorRol: Object
})

// Fecha con formato local
function formatDate(dateString) {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleString('es-BO', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

// Estructura modular para tabla
const estructuraModulos = {
  'Gestión': {
    'Usuarios': 'usuarios',
    'Personal Interno': 'personal_interno',
    'Lecturadores': 'lecturadores',
    'Zona': 'zona',
    'Predios': 'predios',
    'Instalaciones': 'instalaciones',
    'Asignaciones': 'asignaciones'
  }
}
</script>

<style scoped>
.container {
  max-width: 900px;
}
.card {
  background-color: white;
}
.table-auto {
  border-collapse: collapse;
}
.table-auto th,
.table-auto td {
  border: 1px solid #ddd;
  padding: 6px 10px;
}
.bg-gray-100 {
  background-color: #f7fafc;
}
</style>
