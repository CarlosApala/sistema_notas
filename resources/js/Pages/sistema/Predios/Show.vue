<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalle de Predio</h1>

    <Link href="/sistema/predios" class="btn btn-secondary mb-4">
      Volver al listado
    </Link>

    <div class="card border border-gray-300 rounded p-4 shadow">
      <div class="flex gap-8">
        <!-- Columna izquierda -->
        <div class="w-1/2 space-y-6">
          <div>
            <h2 class="text-lg font-semibold mb-2">Información General</h2>
            <p><strong>ID:</strong> {{ predio.id }}</p>
            <p><strong>Dirección:</strong> {{ predio.direccion || '-' }}</p>
            <p><strong>Ubicación GPS:</strong> {{ predio.ubicaciongps || '-' }}</p>
            <p><strong>Zona/Barrio:</strong> {{ predio.zonaBarrio || '-' }}</p>
            <p><strong>Distrito:</strong> {{ predio.distrito || '-' }}</p>
            <p><strong>Unidad Vecinal:</strong> {{ predio.UnidadVecinal || '-' }}</p>
            <p><strong>Manzana:</strong> {{ predio.Manzana || '-' }}</p>
          </div>

          <div>
            <h2 class="text-lg font-semibold mb-2">Estado y Observaciones</h2>
            <p><strong>Tipo Edificación:</strong> {{ predio.TipoEdificacion || '-' }}</p>
            <p><strong>Pavimento:</strong> {{ predio.Pavimento ? 'Sí' : 'No' }}</p>
            <p><strong>Estado Edificación:</strong> {{ predio.EstadoEdificacion || '-' }}</p>
            <p><strong>Predio Habitado:</strong> {{ predio.PredioHabitado ? 'Sí' : 'No' }}</p>
            <p><strong>Observaciones:</strong> {{ predio.Observaciones || '-' }}</p>
          </div>
        </div>

        <!-- Columna derecha -->
        <div class="w-1/2 space-y-6">
          <div>
            <h2 class="text-lg font-semibold mb-2">Detalles del Predio</h2>
            <p><strong>Área Predio:</strong> {{ predio.AreaPredio ?? '-' }} m²</p>
            <p><strong>Longitud Frente:</strong> {{ predio.LongitudFrente ?? '-' }} m</p>
            <p><strong>Área Construida:</strong> {{ predio.AreaConstruida ?? '-' }} m²</p>
            <p><strong>Nro. Habitaciones:</strong> {{ predio.NroHaitaciones ?? '-' }}</p>
            <p><strong>Nro. Pisos:</strong> {{ predio.NroPisos ?? '-' }}</p>
            <p><strong>Nro. Grifos:</strong> {{ predio.NroGrifos ?? '-' }}</p>
            <p><strong>Nro. Baños:</strong> {{ predio.NroBaños ?? '-' }}</p>
          </div>

          <div>
            <p><strong>Creado en:</strong> {{ predio.created_at || '-' }}</p>
            <p><strong>Actualizado en:</strong> {{ predio.updated_at || '-' }}</p>
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
  predio: Object,
})
</script>
