<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Crear Nuevo Personal Interno</h1>

        <form @submit.prevent="submit"
            class="bg-white p-6 rounded shadow max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombres -->
            <div>
                <label for="nombres" class="block font-medium mb-1">Nombres</label>
                <input v-model="form.nombres" id="nombres" type="text"
                    class="form-input w-full border rounded px-3 py-2" required />
                <p v-if="errors.nombres" class="text-red-600 text-sm mt-1">{{ errors.nombres }}</p>
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos" class="block font-medium mb-1">Apellidos</label>
                <input v-model="form.apellidos" id="apellidos" type="text"
                    class="form-input w-full border rounded px-3 py-2" required />
                <p v-if="errors.apellidos" class="text-red-600 text-sm mt-1">{{ errors.apellidos }}</p>
            </div>

            <!-- Carnet de Identidad -->
            <div>
                <label for="carnet_identidad" class="block font-medium mb-1">Carnet de Identidad</label>
                <input v-model="form.carnet_identidad" id="carnet_identidad" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.carnet_identidad" class="text-red-600 text-sm mt-1">{{ errors.carnet_identidad }}</p>
            </div>

            <!-- Fecha de Nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block font-medium mb-1">Fecha de Nacimiento</label>
                <input v-model="form.fecha_nacimiento" id="fecha_nacimiento" type="date"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.fecha_nacimiento" class="text-red-600 text-sm mt-1">{{ errors.fecha_nacimiento }}</p>
            </div>

            <!-- Nacionalidad -->
            <div>
                <label for="nacionalidad" class="block font-medium mb-1">Nacionalidad</label>
                <input v-model="form.nacionalidad" id="nacionalidad" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.nacionalidad" class="text-red-600 text-sm mt-1">{{ errors.nacionalidad }}</p>
            </div>

            <!-- Número de Celular -->
            <div>
                <label for="numero_celular" class="block font-medium mb-1">Número de Celular</label>
                <input v-model="form.numero_celular" id="numero_celular" type="tel"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.numero_celular" class="text-red-600 text-sm mt-1">{{ errors.numero_celular }}</p>
            </div>

            <!-- Dirección -->
            <div>
                <label for="direccion" class="block font-medium mb-1">Dirección</label>
                <input v-model="form.direccion" id="direccion" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.direccion" class="text-red-600 text-sm mt-1">{{ errors.direccion }}</p>
            </div>

            <!-- Género -->
            <div>
                <label for="genero" class="block font-medium mb-1">Género</label>
                <select v-model="form.genero" id="genero" class="form-select w-full border rounded px-3 py-2">
                    <option disabled value="">Seleccione...</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
                <p v-if="errors.genero" class="text-red-600 text-sm mt-1">{{ errors.genero }}</p>
            </div>

            <!-- Lugar de Nacimiento -->
            <div>
                <label for="lugar_nacimiento" class="block font-medium mb-1">Lugar de Nacimiento</label>
                <input v-model="form.lugar_nacimiento" id="lugar_nacimiento" type="text"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.lugar_nacimiento" class="text-red-600 text-sm mt-1">{{ errors.lugar_nacimiento }}</p>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input v-model="form.email" id="email" type="email"
                    class="form-input w-full border rounded px-3 py-2" />
                <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
            </div>


            <!-- Botón de Guardar -->
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
                <Link href="/nLecturaMovil/sistema/personal_interno"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import { route } from 'ziggy-js' // ✅ Correcto
defineOptions({ layout: App })

const form = ref({
    nombres: '',
    apellidos: '',
    carnet_identidad: '',
    fecha_nacimiento: '',
    nacionalidad: '',
    numero_celular: '',
    direccion: '',
    genero: '',
    lugar_nacimiento: '',
    email: '',
})


const errors = ref({})
const processing = ref(false)

function submit() {
    processing.value = true
    errors.value = {}

    router.post(route('personal_interno.store'), form.value, {
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

<style scoped>
.form-input {
    outline: none;
    transition: border-color 0.2s;
}

.form-input:focus {
    border-color: #2563eb;
}
</style>
