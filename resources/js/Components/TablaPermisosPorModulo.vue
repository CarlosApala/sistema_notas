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
          <template v-for="(prefix, grupo, index) in grupos" :key="grupo">
            <tr>
              <td
                v-if="index === 0"
                class="border px-3 py-2 font-semibold text-center"
                :rowspan="Object.keys(grupos).length"
              >
                {{ modulo }}
              </td>
              <td class="border px-3 py-2 font-medium">{{ grupo }}</td>

              <!-- ✅ Columna TODOS -->
              <td
                class="border px-3 py-2 text-center"
                :class="bloqueado ? '' : 'cursor-pointer hover:bg-blue-50'"
                @click="!bloqueado && toggleGrupo(prefix)"
              >
                <template v-if="bloqueado">
                  {{
                    acciones.every(a => modelValue.includes(`${prefix}.${a}`))
                      ? '✔️'
                      : '❌'
                  }}
                </template>
                <template v-else>
                  <input
                    type="checkbox"
                    :checked="acciones.every(a => modelValue.includes(`${prefix}.${a}`))"
                      @change="toggleGrupo(prefix)"
                    @click.stop
                  />
                </template>
              </td>

              <!-- ✅ Celdas por acción -->
              <td
                v-for="accion in acciones"
                :key="accion"
                class="border px-3 py-2 text-center"
                :class="bloqueado ? '' : 'cursor-pointer hover:bg-blue-50'"
                @click="!bloqueado && togglePermiso(`${prefix}.${accion}`)"
              >
                <template v-if="bloqueado">
                  {{ modelValue.includes(`${prefix}.${accion}`) ? '✔️' : '❌' }}
                </template>
                <template v-else>
                  <input
                    type="checkbox"
                    :checked="modelValue.includes(`${prefix}.${accion}`)"
                    @click.stop
                  />
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
  estructura: Object,
  modelValue: Array,
  acciones: {
    type: Array,
    default: () => [
      'ver',
      'crear',
      'editar',
      'eliminar',
      'eliminados',
      'restaurar'
    ]
  },
  bloqueado: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

function togglePermiso(permiso) {
  const permisosActuales = [...props.modelValue]
  const index = permisosActuales.indexOf(permiso)

  if (index === -1) {
    permisosActuales.push(permiso)
  } else {
    permisosActuales.splice(index, 1)
  }

  emit('update:modelValue', permisosActuales)
}

function toggleGrupo(prefix) {
  const permisosActuales = [...props.modelValue]
  const permisosGrupo = props.acciones.map(a => `${prefix}.${a}`)
  const todosIncluidos = permisosGrupo.every(p => permisosActuales.includes(p))

  if (todosIncluidos) {
    // desmarcar todos
    emit('update:modelValue', permisosActuales.filter(p => !permisosGrupo.includes(p)))
  } else {
    // agregar los que faltan
    permisosGrupo.forEach(p => {
      if (!permisosActuales.includes(p)) {
        permisosActuales.push(p)
      }
    })
    emit('update:modelValue', permisosActuales)
  }
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
.cursor-pointer {
  cursor: pointer;
}
.hover\:bg-blue-50:hover {
  background-color: #ebf4ff;
}
</style>
