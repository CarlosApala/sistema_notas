<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md">
            <!-- Alerta de éxito -->
            <div v-if="successMessage"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ successMessage }}
            </div>


            <!-- Alerta de error -->
            <div v-if="form.hasErrors" class="bg-red-100 text-red-800 p-4 rounded mb-4 shadow">
                Corrige los errores en el formulario.
            </div>

            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b text-center text-lg font-bold">
                    Registrar Zona
                </div>
                <div class="p-6">
                    <form @submit.prevent="submitZona">
                        <div class="mb-4">
                            <label for="NombreZona" class="block text-gray-700 font-medium mb-1">Nombre de la
                                Zona</label>
                            <input v-model="form.NombreZona" type="text" id="NombreZona"
                                class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Ingrese el nombre" />
                            <p v-if="form.errors.NombreZona" class="text-red-600 text-sm mt-1">
                                {{ form.errors.NombreZona }}
                            </p>
                        </div>
                        <div class="text-right">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                                Registrar Zona
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { computed, onMounted } from 'vue'
import Swal from 'sweetalert2'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const page = usePage() // Esto devuelve un objeto reactivo
const form = useForm({
    NombreZona: '',
})

// Mensaje de éxito desde el flash
const successMessage = computed(() => page.props.flash?.success || '')

onMounted(() => {
    if (successMessage.value) {
        Swal.fire('¡Registrado!', successMessage.value, 'success')
    }
})

function submitZona() {
    form.post('/sistema/zonas', {
        onSuccess: () => {
            form.reset()
        },
    })
}
</script>
