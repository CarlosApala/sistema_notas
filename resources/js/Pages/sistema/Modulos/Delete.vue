<script setup>
import TablaBusqueda from '@/Components/TablaBusqueda.vue';
import App from "@/Layouts/AppLayout.vue";


defineOptions({ layout: App });

const columnas = [
  { key: 'id', label: 'ID' },
  { key: 'nombre', label: 'Nombre' },
  { key: 'descripcion', label: 'Descripción' },
];

const fetchUrl = route('api.modulos'); // Ruta API para obtener módulos

const eliminarModulo = async (id) => {
  if (!confirm('¿Estás seguro de eliminar este módulo?')) return;

  try {
    const url = route('api.modulos.destroy', { modulo: id });
    const res = await fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      },
    });

    if (!res.ok) throw new Error('Error al eliminar');

    alert('Módulo eliminado correctamente.');

    // Recargar la tabla recargando la página o mejor emitir evento para recargar (a implementar)
    window.location.reload();
  } catch (error) {
    alert('No se pudo eliminar el módulo.');
    console.error(error);
  }
};
</script>

<template>
  <TablaBusqueda
    :titulo="'Listado de Módulos'"
    :fetchUrl="fetchUrl"
    :columnas="columnas"
    :perPage="10"
  >
    <template #row="{ item }">
      <td class="p-2 border">{{ item.id }}</td>
      <td class="p-2 border">{{ item.nombre }}</td>
      <td class="p-2 border">{{ item.descripcion }}</td>
      <td class="p-2 border space-x-2">

        <button
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
          @click="eliminarModulo(item.id)"
          type="button"
        >
          Eliminar
        </button>
      </td>
    </template>
  </TablaBusqueda>
</template>
