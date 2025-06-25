<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Crear Nuevo Predio</h1>

        <form @submit.prevent="submit"
            class="bg-white p-6 rounded shadow max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Dirección ocupa 2 columnas -->
            <div class="md:col-span-2">
                <label for="direccion" class="block font-medium mb-1">Dirección</label>
                <input v-model="form.direccion" id="direccion" type="text"
                    class="form-input w-full border rounded px-3 py-2" required />
                <p v-if="errors.direccion" class="text-red-600 text-sm mt-1">{{ errors.direccion }}</p>
            </div>

            <div>
                <label for="ubicaciongps" class="block font-medium mb-1">Ubicación GPS</label>
                <input v-model="form.ubicaciongps" id="ubicaciongps" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.ubicaciongps" class="text-red-600 text-sm mt-1">{{ errors.ubicaciongps }}</p>
            </div>

            <div>
                <label for="zonaBarrio" class="block font-medium mb-1">Zona/Barrio</label>
                <input v-model="form.zonaBarrio" id="zonaBarrio" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.zonaBarrio" class="text-red-600 text-sm mt-1">{{ errors.zonaBarrio }}</p>
            </div>

            <div>
                <label for="distrito" class="block font-medium mb-1">Distrito</label>
                <input v-model="form.distrito" id="distrito" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.distrito" class="text-red-600 text-sm mt-1">{{ errors.distrito }}</p>
            </div>

            <div>
                <label for="UnidadVecinal" class="block font-medium mb-1">Unidad Vecinal</label>
                <input v-model="form.UnidadVecinal" id="UnidadVecinal" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.UnidadVecinal" class="text-red-600 text-sm mt-1">{{ errors.UnidadVecinal }}</p>
            </div>

            <div>
                <label for="Manzana" class="block font-medium mb-1">Manzana</label>
                <input v-model="form.Manzana" id="Manzana" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.Manzana" class="text-red-600 text-sm mt-1">{{ errors.Manzana }}</p>
            </div>

            <!-- Área Predio ocupa 1 columna -->
            <div>
                <label for="AreaPredio" class="block font-medium mb-1">Área Predio (m²)</label>
                <input v-model.number="form.AreaPredio" id="AreaPredio" type="number" step="0.01" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.AreaPredio" class="text-red-600 text-sm mt-1">{{ errors.AreaPredio }}</p>
            </div>

            <!-- Longitud Frente ocupa 1 columna -->
            <div>
                <label for="LongitudFrente" class="block font-medium mb-1">Longitud Frente (m)</label>
                <input v-model.number="form.LongitudFrente" id="LongitudFrente" type="number" step="0.01" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.LongitudFrente" class="text-red-600 text-sm mt-1">{{ errors.LongitudFrente }}</p>
            </div>

            <!-- Área Construida ocupa 1 columna -->
            <div>
                <label for="AreaConstruida" class="block font-medium mb-1">Área Construida (m²)</label>
                <input v-model.number="form.AreaConstruida" id="AreaConstruida" type="number" step="0.01" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.AreaConstruida" class="text-red-600 text-sm mt-1">{{ errors.AreaConstruida }}</p>
            </div>

            <!-- Número Habitaciones -->
            <div>
                <label for="NroHaitaciones" class="block font-medium mb-1">Número Habitaciones</label>
                <input v-model.number="form.NroHaitaciones" id="NroHaitaciones" type="number" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.NroHaitaciones" class="text-red-600 text-sm mt-1">{{ errors.NroHaitaciones }}</p>
            </div>

            <!-- Número Pisos -->
            <div>
                <label for="NroPisos" class="block font-medium mb-1">Número Pisos</label>
                <input v-model.number="form.NroPisos" id="NroPisos" type="number" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.NroPisos" class="text-red-600 text-sm mt-1">{{ errors.NroPisos }}</p>
            </div>

            <!-- Número Grifos -->
            <div>
                <label for="NroGrifos" class="block font-medium mb-1">Número Grifos</label>
                <input v-model.number="form.NroGrifos" id="NroGrifos" type="number" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.NroGrifos" class="text-red-600 text-sm mt-1">{{ errors.NroGrifos }}</p>
            </div>

            <!-- Número Baños -->
            <div>
                <label for="NroBaños" class="block font-medium mb-1">Número Baños</label>
                <input v-model.number="form.NroBaños" id="NroBaños" type="number" min="0"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.NroBaños" class="text-red-600 text-sm mt-1">{{ errors.NroBaños }}</p>
            </div>

            <!-- Tipo Edificación ocupa 2 columnas -->
            <div class="md:col-span-2">
                <label for="TipoEdificacion" class="block font-medium mb-1">Tipo Edificación</label>
                <input v-model="form.TipoEdificacion" id="TipoEdificacion" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.TipoEdificacion" class="text-red-600 text-sm mt-1">{{ errors.TipoEdificacion }}</p>
            </div>

            <!-- Pavimento y Predio Habitado en una fila lado a lado -->
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <input v-model="form.Pavimento" id="Pavimento" type="checkbox" class="form-checkbox" />
                    <label for="Pavimento" class="font-medium">Pavimento</label>
                </div>
                <div class="flex items-center gap-2">
                    <input v-model="form.PredioHabitado" id="PredioHabitado" type="checkbox" class="form-checkbox" />
                    <label for="PredioHabitado" class="font-medium">Predio Habitado</label>
                </div>
            </div>

            <p v-if="errors.Pavimento" class="text-red-600 text-sm mt-1 md:col-span-2">{{ errors.Pavimento }}</p>
            <p v-if="errors.PredioHabitado" class="text-red-600 text-sm mt-1 md:col-span-2">{{ errors.PredioHabitado }}
            </p>

            <!-- Estado Edificación ocupa 2 columnas -->
            <div class="md:col-span-2">
                <label for="EstadoEdificacion" class="block font-medium mb-1">Estado Edificación</label>
                <input v-model="form.EstadoEdificacion" id="EstadoEdificacion" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.EstadoEdificacion" class="text-red-600 text-sm mt-1">{{ errors.EstadoEdificacion }}</p>
            </div>

            <!-- Observaciones ocupa 2 columnas -->
            <div class="md:col-span-2">
                <label for="Observaciones" class="block font-medium mb-1">Observaciones</label>
                <textarea v-model="form.Observaciones" id="Observaciones" rows="3"
                    class="form-textarea w-full border rounded px-3 py-2"></textarea>
                <p v-if="errors.Observaciones" class="text-red-600 text-sm mt-1">{{ errors.Observaciones }}</p>
            </div>

            <!-- Botón ocupa 2 columnas -->
            <div class="md:col-span-2 flex justify-end space-x-2">
                <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-6 py-2"
                    :disabled="processing">
                    <span v-if="processing" class="mr-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>
                        </svg>
                    </span>
                    Guardar
                </button>
                <Link href="/sistema/predios"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>

<style scoped>
.form-input,
.form-textarea,
.form-select {
    outline: none;
    transition: border-color 0.2s;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    border-color: #2563eb;
}

.form-checkbox {
    width: 1.25rem;
    height: 1.25rem;
}
</style>


<script setup>
import { ref } from 'vue'
import { router,Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const form = ref({
    direccion: '',
    ubicaciongps: '',
    zonaBarrio: '',
    distrito: '',
    UnidadVecinal: '',
    Manzana: '',
    AreaPredio: null,
    LongitudFrente: null,
    AreaConstruida: null,
    NroHaitaciones: null,
    NroPisos: null,
    NroGrifos: null,
    NroBaños: null,
    TipoEdificacion: '',
    Pavimento: false,
    EstadoEdificacion: '',
    PredioHabitado: false,
    Observaciones: '',
})

const errors = ref({})
const processing = ref(false)

function submit() {
    processing.value = true
    errors.value = {}

    router.post('/sistema/predios', form.value, {
        onSuccess: () => {
            processing.value = false
        },
        onError: (err) => {
            processing.value = false
            errors.value = err
        },
    })
}
</script>
