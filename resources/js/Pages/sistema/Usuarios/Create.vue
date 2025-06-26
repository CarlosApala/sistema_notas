<template>
    <div class="container mx-auto p-6">
        <!-- Encabezado -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
            <p class="text-gray-600 mt-1">En esta pantalla se dará de alta a un personal interno en el sistema.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- FORMULARIO -->
            <div class="bg-white border rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Formulario</h2>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Nombres</label>
                        <input v-model="form.nombres" type="text" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Apellidos</label>
                        <input v-model="form.apellidos" type="text" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Carnet de Identidad</label>
                        <input v-model="form.carnet_identidad" type="text" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Número de Celular</label>
                        <input v-model="form.numero_celular" type="text" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Rol (opcional)</label>
                        <select v-model="form.rol" class="w-full border rounded px-3 py-2">
                            <option value="">-- Sin rol asignado --</option>
                            <option v-for="rol in roles" :key="rol.id" :value="rol.name">{{ rol.name }}</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>

            <!-- TABLA DE USUARIOS -->
            <div class="bg-white border rounded shadow p-6 overflow-auto">
                <h2 class="text-lg font-semibold mb-4">Usuarios Personal Interno</h2>

                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Nombre</th>
                            <th class="p-2 border">CI</th>
                            <th class="p-2 border">Celular</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="persona in personas.data" :key="persona.id"
                            class="hover:bg-blue-50 transition cursor-pointer"
                            @click="fillForm(persona)"
                        >
                            <td class="p-2 border">{{ persona.id }}</td>
                            <td class="p-2 border">{{ persona.nombres }} {{ persona.apellidos }}</td>
                            <td class="p-2 border">{{ persona.carnet_identidad }}</td>
                            <td class="p-2 border">{{ persona.numero_celular }}</td>
                        </tr>
                        <tr v-if="personas.data.length === 0">
                            <td colspan="4" class="text-center py-4 text-gray-500">No hay registros aún.</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="mt-4 flex justify-center gap-2">
                    <button v-for="(link, i) in personas.links" :key="i" v-html="link.label" @click="goTo(link.url)"
                        :disabled="!link.url" class="px-3 py-1 border rounded text-sm" :class="{
                            'bg-blue-600 text-white': link.active,
                            'text-gray-500': !link.url,
                            'hover:bg-gray-100': link.url
                        }" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
    personas: Object, // datos paginados
    roles: Array,     // roles disponibles para el select
})

const form = useForm({
    nombres: '',
    apellidos: '',
    carnet_identidad: '',
    numero_celular: '',
    rol: '',  // campo rol
})

function submit() {
    form.post('/sistema/usuarios', {
        onSuccess: () => form.reset()
    })
}

function goTo(url) {
    if (url) {
        router.visit(url)
    }
}

function fillForm(persona) {
    form.nombres = persona.nombres
    form.apellidos = persona.apellidos
    form.carnet_identidad = persona.carnet_identidad
    form.numero_celular = persona.numero_celular
    form.rol = persona.rol || ''
}
</script>
