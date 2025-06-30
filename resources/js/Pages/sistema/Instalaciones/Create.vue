<template>
    <div class="container mx-auto p-4 max-w-4xl">
        <h1 class="text-2xl font-bold mb-6">Registrar Nueva Instalación</h1>

        <form @submit.prevent="submit" class="bg-white p-6 rounded shadow max-w-full space-y-6">
            <!-- Botones arriba -->
            <div class="flex justify-end space-x-2">
                <button type="submit"
                    class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2 flex items-center"
                    :disabled="processing || !form.idPredio" title="Seleccione un predio para habilitar">
                    <span v-if="processing" class="mr-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                    Guardar
                </button>
                <Link href="/sistema/instalaciones"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white rounded px-4 py-2">
                Cancelar
                </Link>
            </div>

            <!-- Selector de Predio con Modal (ahora en grid de 2 columnas junto a Fecha de Instalación) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Predio</label>
                    <div class="flex gap-2 items-center">
                        <input type="text" class="form-input w-full border rounded px-3 py-2 bg-gray-100"
                            :value="selectedPredioDisplay" readonly placeholder="Ningún predio seleccionado" />
                        <button type="button" class="btn btn-secondary"
                            @click="showPredioModal = true">
                            Seleccionar
                        </button>
                    </div>
                    <p v-if="errors.idPredio" class="text-red-600 text-sm mt-1">{{ errors.idPredio }}</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">Fecha de Instalación</label>
                    <input type="date" v-model="form.FechaInstalacion"
                        class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.FechaInstalacion" class="text-red-600 text-sm mt-1">{{ errors.FechaInstalacion }}
                    </p>
                </div>
            </div>

            <!-- Número de Medidor y Estado de Instalación en 2 columnas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Número de Medidor</label>
                    <input type="text" v-model="form.NumeroMedidor"
                        class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.NumeroMedidor" class="text-red-600 text-sm mt-1">{{ errors.NumeroMedidor }}</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">Estado de Instalación</label>
                    <input type="text" v-model="form.EstadoInstalacion"
                        class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.EstadoInstalacion" class="text-red-600 text-sm mt-1">{{ errors.EstadoInstalacion }}
                    </p>
                </div>
            </div>

            <!-- Estado de Alcantarillado ocupa toda la fila -->
            <div>
                <label class="block font-medium mb-1">Estado de Alcantarillado</label>
                <input type="text" v-model="form.EstadoAlcantarillado"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.EstadoAlcantarillado" class="text-red-600 text-sm mt-1">{{ errors.EstadoAlcantarillado
                    }}</p>
            </div>

            <!-- Observaciones ocupa toda la fila -->
            <div>
                <label class="block font-medium mb-1">Observaciones</label>
                <textarea v-model="form.Observaciones" class="form-input w-full border rounded px-3 py-2"
                    rows="3"></textarea>
                <p v-if="errors.Observaciones" class="text-red-600 text-sm mt-1">{{ errors.Observaciones }}</p>
            </div>

            <!-- Grifos y Baños en dos columnas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Nro Grifos</label>
                    <input type="number" v-model="form.NroGrifos" class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.NroGrifos" class="text-red-600 text-sm mt-1">{{ errors.NroGrifos }}</p>
                </div>
                <div>
                    <label class="block font-medium mb-1">Nro Baños</label>
                    <input type="number" v-model="form.NroBaños" class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.NroBaños" class="text-red-600 text-sm mt-1">{{ errors.NroBaños }}</p>
                </div>
            </div>

            <!-- Corte, Promedio y Ubicación en 3 columnas responsivas -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium mb-1">Estado Corte</label>
                    <input type="text" v-model="form.EstadoCorte" class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.EstadoCorte" class="text-red-600 text-sm mt-1">{{ errors.EstadoCorte }}</p>
                </div>
                <div>
                    <label class="block font-medium mb-1">Promedio Consumo</label>
                    <input type="number" step="0.01" v-model="form.PromedioConsumo"
                        class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.PromedioConsumo" class="text-red-600 text-sm mt-1">{{ errors.PromedioConsumo }}</p>
                </div>
                <div>
                    <label class="block font-medium mb-1">Código Ubicación</label>
                    <input type="text" v-model="form.CodigoUbicacion"
                        class="form-input w-full border rounded px-3 py-2" />
                    <p v-if="errors.CodigoUbicacion" class="text-red-600 text-sm mt-1">{{ errors.CodigoUbicacion }}</p>
                </div>
            </div>
        </form>

        <!-- Modal para seleccionar predio -->
        <TablaModal :visible="showPredioModal" titulo="Seleccionar Predio" :columnas="[
            { key: 'direccion', label: 'Dirección' },
            { key: 'zonaBarrio', label: 'Zona/Barrio' },
            { key: 'distrito', label: 'Distrito' }
        ]" fetch-url="/api/predios" @close="showPredioModal = false" @select="onSelectPredio" />
    </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import TablaModal from '@/Components/TablaModal.vue'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const showPredioModal = ref(false)
const predioSeleccionado = ref(null)

const predios = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 10,
})
const form = ref({
    idPredio: '',
    FechaInstalacion: '',
    NumeroMedidor: '',
    EstadoInstalacion: '',
    EstadoAlcantarillado: '',
    Observaciones: '',
    NroGrifos: null,
    NroBaños: null,
    EstadoCorte: '',
    PromedioConsumo: null,
    CodigoUbicacion: '',
})


const selectedPredioDisplay = computed(() => {
    if (!predioSeleccionado.value) return ''
    const p = predioSeleccionado.value
    return `${p.direccion} - ${p.zonaBarrio} (${p.distrito})`
})



const errors = ref({})
const processing = ref(false)
const loadingPredios = ref(false)

async function loadPredios(page = 1) {
    loadingPredios.value = true
    try {
        const res = await fetch(`/api/predios?page=${page}`)
        if (!res.ok) throw new Error('Error al cargar predios')
        predios.value = await res.json()
    } catch (e) {
        console.error('Error al cargar predios:', e)
    } finally {
        loadingPredios.value = false
    }
}

// Función para manejar selección del predio
function onSelectPredio(predio) {
    form.value.idPredio = predio.id
    predioSeleccionado.value = predio
    showPredioModal.value = false // opcional: cierra el modal al seleccionar
}

onMounted(() => {
    loadPredios()
})

function selectPredio(id) {
    form.value.idPredio = id
}

function submit() {
    processing.value = true
    errors.value = {}

    router.post('/sistema/instalaciones', form.value, {
        onSuccess: () => {
            processing.value = false
        },
        onError: (err) => {
            processing.value = false
            errors.value = err
        },
    })
}

function goToPage(page) {
    if (page >= 1 && page <= predios.value.last_page) {
        loadPredios(page)
    }
}
</script>

<style scoped>
.form-input,
.form-select {
    outline: none;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-select:focus {
    border-color: #2563eb;
}

/* Texto en celdas con ellipsis */
table th,
table td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
    /* ajustar según sea necesario */
}
</style>
