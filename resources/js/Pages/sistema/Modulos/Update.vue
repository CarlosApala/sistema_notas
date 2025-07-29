<script setup>
import TablaBusqueda from '@/Components/TablaBusqueda.vue';
import App from "@/Layouts/AppLayout.vue";

defineOptions({ layout: App });

const columnas = [
  { key: 'id', label: 'ID' },
  { key: 'nombre', label: 'Nombre' },
  { key: 'descripcion', label: 'Descripción' },
];

const fetchUrl = route('api.modulos'); // La ruta API creada
</script>

<template>
  <TablaBusqueda
    :titulo="'Listado de Módulos'"
    :fetchUrl="fetchUrl"
    :columnas="columnas"
    :perPage="10"
  >
    <!-- Slot para la columna de acciones -->
    <template #row="{ item }">
      <td class="p-2 border">
        {{ item.id }}
      </td>
      <td class="p-2 border">
        {{ item.nombre }}
      </td>
      <td class="p-2 border">
        {{ item.descripcion }}
      </td>
      <td class="p-2 border">
        <button
          class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm"
          @click="$router.push(`/modulos/${item.id}/edit`)"
          type="button"
        >
          Modificar
        </button>
      </td>
    </template>
  </TablaBusqueda>
</template>
