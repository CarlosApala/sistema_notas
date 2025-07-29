<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
  fetchUrl: String,
  columnas: Array,
  perPage: {
    type: Number,
    default: 10,
  },
  titulo: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['rowClick'])

const items = ref([])
const total = ref(0)
const currentPage = ref(1)
const search = ref('')
const loading = ref(false)

const links = ref([])

async function fetchData() {
  loading.value = true
  try {
    const url = new URL(props.fetchUrl, window.location.origin)
    url.searchParams.set('page', currentPage.value)
    url.searchParams.set('per_page', props.perPage)
    if (search.value) url.searchParams.set('search', search.value)

    const response = await fetch(url.toString())
    const data = await response.json()

    items.value = data.data
    total.value = data.total
    links.value = data.links
  } catch (e) {
    console.error('Error al cargar datos:', e)
  } finally {
    loading.value = false
  }
}

function handleRowClick(item) {
  emit('rowClick', item)
}

watch([search, currentPage], fetchData)
onMounted(fetchData)
</script>

<template>
  <div class="bg-white shadow rounded p-4">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold">{{ titulo }}</h3>
      <input
        type="text"
        class="border px-3 py-1 rounded"
        placeholder="Buscar..."
        v-model="search"
      />
    </div>

    <div v-if="loading" class="text-center py-4 text-gray-500">Cargando...</div>

    <table v-else class="min-w-full border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th v-for="col in columnas" :key="col.key" class="p-2 border-b">
            {{ col.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item.id"
          class="hover:bg-gray-50 cursor-pointer"
          @click="handleRowClick(item)"
        >
          <td
            v-for="col in columnas"
            :key="col.key"
            class="p-2 border-b"
          >
            {{ item[col.key] }}
          </td>
        </tr>
        <tr v-if="items.length === 0">
          <td :colspan="columnas.length" class="text-center p-4 text-gray-500">
            No hay resultados
          </td>
        </tr>
      </tbody>
    </table>

    <!-- PAGINACIÓN -->
    <div class="flex justify-center gap-2 mt-4" v-if="links.length > 3">
      <button
        v-for="link in links"
        :key="link.label"
        v-html="link.label"
        :disabled="!link.url || link.active"
        @click="() => {
          if (link.url) {
            const match = link.url.match(/page=(\d+)/)
            currentPage.value = match ? parseInt(match[1]) : 1
          }
        }"
        class="px-3 py-1 border rounded text-sm"
        :class="{
          'bg-blue-500 text-white': link.active,
          'text-gray-700': !link.active && link.url,
          'opacity-50 cursor-not-allowed': !link.url
        }"
      />
    </div>
  </div>
</template>
