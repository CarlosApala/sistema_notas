<script setup>
import { ref, reactive } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import axios from 'axios';

import App from "@/Layouts/AppLayout.vue";
import TablaModal from "@/Components/TablaModal.vue";
import TablaPermisosPorModulo from "@/Components/TablaPermisosPorModulo.vue";

defineOptions({ layout: App });

const page = usePage();
const moduloId = page.props.modulo.id;

// Haz reactivos los datos que pueden cambiar
const permisosUsuario = ref(page.props.permisosUsuario || []);
const estructuraModulos = reactive(page.props.estructuraModulos || {});

const showModal = ref(false);

const form = useForm({
  permiso_id: null,
  nombre_permiso: "",
  codigo_permiso: "",
});

const columnasTabla = [
  { key: "id", label: "ID" },
  { key: "nombre", label: "Nombre" },
  { key: "name", label: "Código" },
];

const columnasModal = [
  { key: "id", label: "ID" },
  { key: "nombre", label: "Nombre" },
  { key: "name", label: "Código" },
];

// URLs para fetch
const fetchPermisos = route("api.permissions.by-modulo", { modulo_id: moduloId }, false);
const fetchPermisosNoAsignados = route("api.permissions.noModulo", {}, false);

function abrirModal() {
  showModal.value = true;
}

function cerrarModal() {
  showModal.value = false;
}

function seleccionarModulo(permiso) {
  form.permiso_id = permiso.id;
  form.nombre_permiso = permiso.nombre || "";
  form.codigo_permiso = permiso.name || "";
  showModal.value = false;
}

// Función que transforma la respuesta API en la estructura y permisos que necesita tu componente
function transformarPermisos(permisosArray) {
  // permisosArray es un array de objetos permiso [{id, name, nombre, modulo_id, programa?}, ...]

  // Primero obtenemos un objeto estructura vacío
  const estructura = {};

  // Agrupamos los permisos por modulo y programa (programa lo obtienes desde backend o lo extraes del nombre)
  permisosArray.forEach(p => {
    // Asumo que el nombre del módulo viene en p.modulo o lo deduces, sino p.modulo_id
    // Como el API no devuelve módulo nombre, puedes usar page.props.modulo.nombre para el módulo actual
    const moduloNombre = page.props.modulo.nombre || 'Módulo';

    // Si no existe el módulo en estructura, lo creamos
    if (!estructura[moduloNombre]) estructura[moduloNombre] = {};

    // El programa sería la parte antes del '.' en p.name
    const programa = p.name.split('.')[0];

    // Usa p.nombre como label del programa si existe, sino el programa
    estructura[moduloNombre][p.nombre || programa] = programa;
  });

  // Permisos planos solo nombres
  const permisosPlanos = permisosArray.map(p => p.name);

  return { estructura, permisosPlanos };
}

async function submit() {
  if (!form.permiso_id) {
    console.error("No hay permiso seleccionado para actualizar");
    return;
  }

  try {
    await router.put(
      route("permisos.update", form.permiso_id),
      { modulo_id: moduloId },
      { preserveScroll: true }
    );

    alert("Permiso asignado correctamente");

    // Limpia el formulario
    form.reset();

    // Recarga y transforma los permisos para actualizar la UI
    await recargarPermisos();

  } catch (error) {
    console.error("Errores al guardar:", error);
  }
}

async function recargarPermisos() {
  try {
    const response = await axios.get(route('api.permissions.by-modulo', { modulo_id: moduloId }));

    // response.data.data tiene el arreglo paginado de permisos
    const permisosArray = response.data.data || [];

    // transforma a la estructura y permisos para TablaPermisosPorModulo
    const { estructura, permisosPlanos } = transformarPermisos(permisosArray);

    // Actualiza las variables reactivas
    // Usamos Vue.set o reasignamos porque estructuraModulos es reactive
    for (const key in estructuraModulos) {
      delete estructuraModulos[key];
    }
    Object.assign(estructuraModulos, estructura);

    permisosUsuario.value = permisosPlanos;

  } catch (error) {
    console.error("Error al recargar permisos:", error);
  }
}
</script>

<template>
  <div class="p-6 max-w-4xl mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Asignar Permiso al Módulo</h2>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Nombre del permiso</label>
        <input
          type="text"
          readonly
          class="mt-1 w-full border px-3 py-2 rounded"
          v-model="form.nombre_permiso"
          @focus="abrirModal"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Código</label>
        <input
          type="text"
          readonly
          class="mt-1 w-full border px-3 py-2 rounded"
          v-model="form.codigo_permiso"
          @focus="abrirModal"
        />
      </div>

      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Guardar
      </button>
    </form>

    <TablaPermisosPorModulo
      :estructura="estructuraModulos"
      :modelValue="permisosUsuario"
      :bloqueado="true"
    />

    <TablaModal
      :visible="showModal"
      titulo="Seleccione un permiso"
      :fetch-url="fetchPermisosNoAsignados"
      :columnas="columnasModal"
      @select="seleccionarModulo"
      @close="cerrarModal"
    />

  </div>
</template>
