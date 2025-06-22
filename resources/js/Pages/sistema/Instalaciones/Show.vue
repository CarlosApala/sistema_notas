<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle de Instalación</h1>

    <Link href="/sistema/instalaciones" class="btn btn-secondary mb-4">
      Volver al listado
    </Link>

    <div class="card border border-gray-300 rounded p-4 shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Columna Izquierda: Datos Instalación -->
        <div>
          <h2 class="text-lg font-semibold mb-3">Información General</h2>
          <p><strong>ID:</strong> {{ instalacion.id }}</p>
          <p><strong>Fecha Instalación:</strong> {{ instalacion.FechaInstalacion || '-' }}</p>
          <p><strong>Número Medidor:</strong> {{ instalacion.NumeroMedidor || '-' }}</p>
          <p><strong>Estado Instalación:</strong> {{ instalacion.EstadoInstalacion || '-' }}</p>
          <p><strong>Estado Alcantarillado:</strong> {{ instalacion.EstadoAlcantarillado || '-' }}</p>
          <p><strong>Estado Corte:</strong> {{ instalacion.EstadoCorte || '-' }}</p>
          <p><strong>Observaciones:</strong> {{ instalacion.Observaciones || '-' }}</p>
          <p><strong>Nro Grifos:</strong> {{ instalacion.NroGrifos ?? '-' }}</p>
          <p><strong>Nro Baños:</strong> {{ instalacion.NroBaños ?? '-' }}</p>
          <p><strong>Promedio Consumo:</strong> {{ instalacion.PromedioConsumo ?? '-' }}</p>
          <p><strong>Código Ubicación:</strong> {{ instalacion.CodigoUbicacion || '-' }}</p>
          <p><strong>Creado en:</strong> {{ instalacion.created_at }}</p>
          <p><strong>Actualizado en:</strong> {{ instalacion.updated_at }}</p>
        </div>

        <!-- Columna Derecha: Datos Predio -->
        <div>
          <h2 class="text-lg font-semibold mb-3">Datos del Predio</h2>
          <p><strong>ID Predio:</strong> {{ instalacion.predio.id }}</p>
          <p><strong>Dirección:</strong> {{ instalacion.predio.direccion || '-' }}</p>
          <p><strong>Barrio/Zona:</strong> {{ instalacion.predio.zonaBarrio || '-' }}</p>
          <p><strong>Distrito:</strong> {{ instalacion.predio.distrito || '-' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
  instalacion: Object,
})
</script>
