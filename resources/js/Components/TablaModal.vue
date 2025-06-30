<template>
    <teleport to="body">
        <div v-if="visible" class="modal-overlay" @click="emit('close')"></div>
        <transition name="slide">
            <aside v-if="visible" class="sidebar" @click.self="emit('close')">
                <header class="sidebar-header flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">{{ titulo }}</h2>
                    <button @click="emit('close')" class="text-2xl font-bold px-2 py-0" aria-label="Cerrar modal">
                        &times;
                    </button>
                </header>

                <div>
                    <input v-model="search" @input="fetchData" type="text" placeholder="Buscar..."
                        class="form-input w-full mb-4 border px-3 py-2 rounded" />

                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th v-for="col in columnas" :key="col.key" class="border px-3 py-2 text-left"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ col.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in registros" :key="item.id" class="cursor-pointer hover:bg-blue-100"
                                @click="emit('select', item); emit('close')"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <td v-for="col in columnas" :key="col.key" class="border px-3 py-2"
                                    style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ item[col.key] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="flex justify-between items-center mt-4">
                        <button :disabled="paginaActual <= 1" @click="paginaActual--; fetchData()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            Anterior
                        </button>
                        <span>Página {{ paginaActual }}</span>
                        <button :disabled="!tieneMas" @click="paginaActual++; fetchData()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            Siguiente
                        </button>
                    </div>
                </div>
            </aside>
        </transition>
    </teleport>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
    visible: Boolean,
    titulo: String,
    columnas: Array, // [{ key: 'name', label: 'Nombre' }]
    fetchUrl: String,
    perPage: { type: Number, default: 10 }
})

const emit = defineEmits(['close', 'select'])

const search = ref('')
const registros = ref([])
const paginaActual = ref(1)
const tieneMas = ref(true)

async function fetchData() {
    try {
        const url = new URL(props.fetchUrl, window.location.origin)
        url.searchParams.set('search', search.value)
        url.searchParams.set('page', paginaActual.value)
        url.searchParams.set('per_page', props.perPage)

        const res = await fetch(url)
        const data = await res.json()

        registros.value = data.data || data
        tieneMas.value = !!data.next_page_url || (data.meta?.current_page < data.meta?.last_page)
    } catch (e) {
        console.error('Error al cargar datos', e)
    }
}

watch(() => props.visible, (val) => {
    if (val) {
        paginaActual.value = 1
        fetchData()
    }
})

onMounted(() => {
    if (props.visible) {
        fetchData()
    }
})
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.3);
    z-index: 9999;
}

.sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 40vw;
    max-width: 500px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 8px rgba(0, 0, 0, 0.15);
    padding: 1.5rem;
    overflow-y: auto;
    z-index: 10000;
}

.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(100%);
}
</style>
