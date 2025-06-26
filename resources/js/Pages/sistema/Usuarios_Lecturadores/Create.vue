<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Usuarios sin rol Lecturador</h1>
        <!-- Botón Volver -->

        <Link href="/sistema/usuarios_lecturadores"
                    class="btn btn-secondary bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Cancelar
                </Link>
        <div v-if="flash.success" class="alert alert-success mb-4 text-green-600">
            {{ flash.success }}
        </div>

        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
                    <td class="py-2 px-4 border-b">{{ user.name }}</td>
                    <td class="py-2 px-4 border-b">{{ user.email }}</td>
                    <td class="py-2 px-4 border-b">
                        <button @click="assignRole(user.id)"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded">
                            Asignar rol Lecturador
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { router, usePage,Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
    users: Array,
})

const flash = usePage().props.flash || {}

function assignRole(userId) {
    console.log(userId)
    router.post(`/sistema/usuarios_lecturadores/${userId}/assign-lecturador`)
}

function goBack() {
  window.history.back()
}


</script>

<style scoped>
table {
    border-collapse: collapse;
}

th,
td {
    text-align: left;
}
</style>
