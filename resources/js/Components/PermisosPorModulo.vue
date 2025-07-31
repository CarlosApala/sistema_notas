<template>
  <div class="overflow-x-auto">
    <table class="table-auto w-full border text-sm text-left">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-3 py-2">Módulo</th>
          <th class="border px-3 py-2">Funcionalidad</th>
          <th class="border px-3 py-2 text-center">Todos</th>
          <th
            v-for="accion in acciones"
            :key="accion"
            class="border px-3 py-2 text-center"
          >
            {{ accion }}
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(grupos, modulo) in estructura" :key="modulo">
          <template
            v-for="(accionesDisponibles, grupo, index) in grupos"
            :key="grupo"
          >
            <tr>
              <!-- Módulo (una sola vez por grupo) -->
              <td
                v-if="index === 0"
                class="border px-3 py-2 font-semibold text-center"
                :rowspan="Object.keys(grupos).length"
              >
                {{ modulo }}
              </td>

              <!-- Funcionalidad -->
              <td class="border px-3 py-2 font-medium">{{ grupo }}</td>

              <!-- Columna TODOS -->
              <td
                class="border px-3 py-2 text-center"
                :class="bloqueado ? 'text-gray-400' : 'cursor-pointer hover:bg-blue-50'"
                @click="!bloqueado && toggleGrupo(modulo, grupo)"
              >
                <template v-if="bloqueado">
                  {{
                    accionesDisponibles.every(p => modelValue.includes(p.name))
                      ? '✔️'
                      : '❌'
                  }}
                </template>
                <template v-else>
                  <input
                    type="checkbox"
                    :checked="accionesDisponibles.every(p => modelValue.includes(p.name))"
                    @change="toggleGrupo(modulo, grupo)"
                    @click.stop
                  />
                </template>
              </td>

              <!-- Celdas por acción -->
              <td
                v-for="accion in acciones"
                :key="accion"
                class="border px-3 py-2 text-center"
              >
                <template v-if="tieneAccion(accionesDisponibles, accion)">
                  <template v-if="bloqueado">
                    {{
                      modelValue.includes(nombrePermiso(accionesDisponibles, accion))
                        ? '✔️'
                        : '❌'
                    }}
                  </template>
                  <template v-else>
                    <input
                      type="checkbox"
                      :checked="modelValue.includes(nombrePermiso(accionesDisponibles, accion))"
                      @change="togglePermiso(nombrePermiso(accionesDisponibles, accion))"
                      @click.stop
                    />
                  </template>
                </template>
                <template v-else>
                  <span class="text-gray-300">—</span>
                </template>
              </td>
            </tr>
          </template>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  estructura: Object, // { modulo: { grupo: [ {accion, name}, ... ] } }
  modelValue: Array,  // [ 'zona.crear', 'producto.ver', ... ]
  acciones: {
    type: Array,
    default: () => ['crear', 'editar', 'eliminar', 'eliminados', 'restaurar', 'ver']
  },
  bloqueado: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

// 🔄 Alternar un permiso individual por name
function togglePermiso(permisoName) {
  const permisosActuales = [...props.modelValue]
  const index = permisosActuales.indexOf(permisoName)

  if (index === -1) {
    permisosActuales.push(permisoName)
  } else {
    permisosActuales.splice(index, 1)
  }

  emit('update:modelValue', permisosActuales)
}

// 🔄 Alternar todos los permisos del grupo
function toggleGrupo(modulo, grupo) {
  const permisosActuales = [...props.modelValue]
  const accionesGrupo = props.estructura[modulo][grupo] || []

  const todosMarcados = accionesGrupo.every(p => permisosActuales.includes(p.name))

  if (todosMarcados) {
    emit(
      'update:modelValue',
      permisosActuales.filter(p => !accionesGrupo.map(a => a.name).includes(p))
    )
  } else {
    accionesGrupo.forEach(({ name }) => {
      if (!permisosActuales.includes(name)) {
        permisosActuales.push(name)
      }
    })
    emit('update:modelValue', permisosActuales)
  }
}

// ✅ Verifica si una acción existe en el grupo
function tieneAccion(lista, accion) {
  return lista.some(p => p.accion === accion)
}

// 🔍 Devuelve el name de una acción (ej. 'zona.crear')
function nombrePermiso(lista, accion) {
  const permiso = lista.find(p => p.accion === accion)
  return permiso ? permiso.name : ''
}
</script>

<style scoped>
.table-auto th,
.table-auto td {
  border: 1px solid #ddd;
  padding: 6px 10px;
}
.bg-gray-100 {
  background-color: #f7fafc;
}
.hover\:bg-blue-50:hover {
  background-color: #ebf4ff;
}
</style>
