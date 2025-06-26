<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle de Instalación</h1>

    <Link href="/sistema/instalaciones" class="btn btn-secondary mb-4">
      Volver al listado
    </Link>

    <div class="card border border-gray-300 rounded p-4 shadow">
      <div class="flex gap-8">
        <!-- Columna izquierda -->
        <div class="w-1/2 space-y-6">
          <div>
            <h2 class="text-lg font-semibold mb-2">Información de Instalación</h2>
            <p><strong>ID:</strong> {{ instalacion.id }}</p>
            <p><strong>Fecha Instalación:</strong> {{ instalacion.FechaInstalacion || '-' }}</p>
            <p><strong>Número de Medidor:</strong> {{ instalacion.NumeroMedidor || '-' }}</p>
            <p><strong>Estado Instalación:</strong> {{ instalacion.EstadoInstalacion || '-' }}</p>
            <p><strong>Estado Alcantarillado:</strong> {{ instalacion.EstadoAlcantarillado || '-' }}</p>
            <p><strong>Estado Corte:</strong> {{ instalacion.EstadoCorte || '-' }}</p>
            <p><strong>Promedio Consumo:</strong> {{ instalacion.PromedioConsumo ?? '-' }} m³</p>
            <p><strong>Observaciones:</strong> {{ instalacion.Observaciones || '-' }}</p>
          </div>

          <div>
            <h2 class="text-lg font-semibold mb-2">Grifos y Baños</h2>
            <p><strong>Nro. Grifos:</strong> {{ instalacion.NroGrifos ?? '-' }}</p>
            <p><strong>Nro. Baños:</strong> {{ instalacion.NroBaños ?? '-' }}</p>
          </div>
        </div>

        <!-- Columna derecha -->
        <div class="w-1/2 space-y-6">
          <div>
            <h2 class="text-lg font-semibold mb-2">Ubicación y Referencias</h2>
            <p><strong>Código Ubicación:</strong> {{ instalacion.CodigoUbicacion || '-' }}</p>
            <p><strong>Predio ID:</strong> {{ instalacion.idPredio }}</p>
            <p><strong>Dirección Predio:</strong> {{ instalacion.predio?.direccion || '-' }}</p>
            <p><strong>Zona/Barrio:</strong> {{ instalacion.predio?.zonaBarrio || '-' }}</p>
            <p><strong>Distrito:</strong> {{ instalacion.predio?.distrito || '-' }}</p>
          </div>

          <div>
            <p><strong>Creado en:</strong> {{ instalacion.created_at?.substring(0, 10) || '-' }}</p>
            <p><strong>Actualizado en:</strong> {{ instalacion.updated_at?.substring(0, 10) || '-' }}</p>
          </div>
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
