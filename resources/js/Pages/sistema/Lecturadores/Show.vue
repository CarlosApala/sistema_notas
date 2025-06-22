<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle de Asignación de Ruta</h1>

    <Link href="/sistema/lecturadores" class="btn btn-secondary mb-4">
      Volver al listado
    </Link>

    <div class="card border border-gray-300 rounded p-4 shadow">
      <div class="mb-4">
        <h2 class="text-lg font-semibold">Asignación</h2>
        <p><strong>ID:</strong> {{ asignacion.id }}</p>
        <p><strong>ID Ruta:</strong> {{ asignacion.idRuta }}</p>
        <p><strong>ID Usuario:</strong> {{ asignacion.idUser }}</p>
        <p><strong>Periodo:</strong> {{ asignacion.periodo || '-' }}</p>
        <p><strong>Creado en:</strong> {{ asignacion.created_at }}</p>
        <p><strong>Actualizado en:</strong> {{ asignacion.updated_at }}</p>
      </div>

      <div v-if="asignacion.rutaInstalacion" class="mb-4">
        <h2 class="text-lg font-semibold">Detalles de la Ruta</h2>
        <p><strong>Nombre Instalación:</strong> {{ asignacion.rutaInstalacion.nInstalacion }}</p>
      </div>

      <div v-if="asignacion.usuario">
        <h2 class="text-lg font-semibold">Datos del Usuario</h2>
        <p><strong>Nombre:</strong> {{ asignacion.usuario.name || 'Sin nombre' }}</p>
        <p><strong>Email:</strong> {{ asignacion.usuario.email || 'Sin email' }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  asignacion: Object,
})
</script>
