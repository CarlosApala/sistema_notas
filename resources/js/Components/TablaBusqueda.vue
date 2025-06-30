<template>
    <div class="bg-white border rounded shadow p-6 overflow-auto">
        <h2 class="text-lg font-semibold mb-4">{{ titulo }}</h2>

        <input
            type="text"
            v-model="busqueda"
            @input="buscar"
            placeholder="Buscar..."
            class="form-input border mb-4 px-3 py-2 w-full rounded"
        />

        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th v-for="col in columnas" :key="col.key" class="p-2 border">
                        {{ col.label }}
                    </th>
                    <!-- Si quieres, acá puedes añadir una columna extra para acciones -->
                    <th v-if="$slots.row" class="p-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="$slots.row">
                    <tr
                        v-for="item in datos.data"
                        :key="item.id"
                        class="hover:bg-blue-50 transition cursor-pointer"
                    >
                        <!-- Slot fila con item pasado -->
                        <slot name="row" :item="item" />
                    </tr>
                    <tr v-if="datos.data.length === 0">
                        <td :colspan="columnas.length + 1" class="text-center py-4 text-gray-500">
                            No hay registros aún.
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr
                        v-for="item in datos.data"
                        :key="item.id"
                        class="hover:bg-blue-50 transition cursor-pointer"
                        @click="onRowClick?.(item)"
                    >
                        <td v-for="col in columnas" :key="col.key" class="p-2 border">
                            {{ item[col.key] }}
                        </td>
                    </tr>
                    <tr v-if="datos.data.length === 0">
                        <td :colspan="columnas.length" class="text-center py-4 text-gray-500">
                            No hay registros aún.
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <div class="mt-4 flex justify-center gap-2">
            <button
                v-for="(link, i) in datos.links"
                :key="i"
                v-html="link.label"
                @click="irAPagina(link.url)"
                :disabled="!link.url"
                class="px-3 py-1 border rounded text-sm"
                :class="{
                    'bg-blue-600 text-white': link.active,
                    'text-gray-500': !link.url,
                    'hover:bg-gray-100': link.url
                }"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    titulo: String,
    fetchUrl: String,
    columnas: Array,
    perPage: {
        type: Number,
        default: 10
    },
    onRowClick: Function,
})

const datos = ref({ data: [], links: [] })
const busqueda = ref('')
const urlActual = ref(props.fetchUrl)

const cargar = async (url = props.fetchUrl) => {
    try {
        const u = new URL(url, window.location.origin)
        u.searchParams.set('search', busqueda.value)
        u.searchParams.set('per_page', props.perPage)

        const res = await fetch(u)
        const json = await res.json()
        datos.value = json
        console.log(json)
        urlActual.value = url
    } catch (e) {
        console.error('Error al cargar datos:', e)
    }
}

const buscar = () => {
    cargar()
}

const irAPagina = (url) => {
    if (url) cargar(url)
}

cargar()
</script>
