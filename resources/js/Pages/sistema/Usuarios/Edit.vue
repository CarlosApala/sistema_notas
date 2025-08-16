<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>

        <form @submit.prevent="submit">
            <!-- Datos básicos -->
            <div class="card border rounded p-4 mb-4">
                <div class="mb-2">
                    <strong>Email:</strong>
                    <input type="email" v-model="form.email" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Usuario:</strong>
                    <input type="text" v-model="form.username" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Nombre:</strong>
                    <input type="text" v-model="form.name" class="input" required />
                </div>
                <div class="mb-2">
                    <strong>Contraseña:</strong>
                    <input type="password" v-model="form.password" class="input" />
                </div>
                <div class="mb-2">
                    <strong>Confirmar contraseña:</strong>
                    <input type="password" v-model="form.password_confirmation" class="input" />
                </div>
                <h4 class="font-semibold mb-2">Programas asignados:</h4>
                <PermisosPorModulo v-model="form.permisos" :estructura="estructuraModulos" :bloqueado="false" />
            </div>

            <!-- Permisos -->


            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import PermisosPorModulo from '@/Components/PermisosPorModulo.vue'

defineOptions({ layout: App })

const props = defineProps({
    user: Object,
    estructuraModulos: Object
})

// Extraer los permisos (names) desde estructuraModulos para el v-model
const permisosIniciales = []
console.log(props.estructuraModulos);
for (const modulo in props.estructuraModulos) {
    for (const programa in props.estructuraModulos[modulo]) {
        props.estructuraModulos[modulo][programa].forEach(p => {
            permisosIniciales.push(p.name)
        })
    }
}

console.log('mostrando permisos')
console.log(permisosIniciales)


// Formulario reactivo
const form = reactive({
    name: props.user.name,
    email: props.user.email,
    username: props.user.username,
    password: '',
    password_confirmation: '',
    permisos: permisosIniciales,
})

// Enviar actualización al backend
function submit() {
    console.log(form);
    router.put(`/nLecturaMovil/sistema/usuarios/${props.user.id}`, form)
}
</script>

<style scoped>
.input {
    width: 100%;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.container {
    max-width: 900px;
}

.card {
    background-color: white;
}
</style>
