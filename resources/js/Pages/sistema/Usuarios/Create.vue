<template>
    <div class="container mx-auto p-6">
        <!-- Encabezado -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
            <p class="text-gray-600 mt-1">
                En esta pantalla se dará de alta a un personal interno en el sistema.
            </p>
        </div>

        <!-- Formulario -->
        <div class="bg-white border rounded shadow p-6 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Formulario</h2>
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700"
                    @click="abrirModal">
                    Seleccionar Usuario
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Nombres</label>
                    <input v-model="form.nombres" type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Apellidos</label>
                    <input v-model="form.apellidos" type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Carnet de Identidad</label>
                    <input v-model="form.carnet_identidad" type="text"
                        class="w-full border rounded px-3 py-2 bg-gray-100" readonly />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Número de Celular</label>
                    <input v-model="form.numero_celular" type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly />
                </div>
                <div>
                    <label class="block mb-1 font-medium">Rol (opcional)</label>
                    <input v-model="form.rol" type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                        readonly />
                </div>

                <!-- Tabla de permisos -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-4">Permisos asignados</h2>
                    <TablaPermisosPorModulo v-model="permisosSeleccionados" :estructura="estructuraPermisos" />
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal de selección de usuario -->
        <TablaModal :visible="modalVisible" titulo="Usuarios Personal Interno" fetch-url="/api/personal_interno"
            :columnas="[
                { key: 'id', label: 'ID' },
                { key: 'nombres', label: 'Nombre' },
                { key: 'carnet_identidad', label: 'CI' },
                { key: 'numero_celular', label: 'Celular' }
            ]" @close="cerrarModal" @select="seleccionarUsuario" />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import TablaModal from '@/Components/TablaModal.vue'
import TablaPermisosPorModulo from '@/Components/TablaPermisosPorModulo.vue'

defineOptions({ layout: App })

const props = defineProps({
    roles: Array,
    estructuraPermisos: Object
})

// Formulario principal
const form = useForm({
    nombres: '',
    apellidos: '',
    carnet_identidad: '',
    numero_celular: '',
    rol: '',
    permisos: [] // ✅ Campo incluido desde el inicio
})
console.log(props.estructuraPermisos);
// Estado para el modal
const modalVisible = ref(false)

// Permisos seleccionados desde la tabla
const permisosSeleccionados = ref([])

// Abrir modal de selección de usuario
function abrirModal() {
    modalVisible.value = true
}

// Cerrar el modal
function cerrarModal() {
    modalVisible.value = false
}

// Asignar datos del usuario seleccionado
function seleccionarUsuario(usuario) {
    form.nombres = usuario.nombres
    form.apellidos = usuario.apellidos
    form.carnet_identidad = usuario.carnet_identidad
    form.numero_celular = usuario.numero_celular
    form.rol = usuario.rol || ''
    cerrarModal()
}

// Enviar el formulario al backend
function submit() {
    form.permisos = [...permisosSeleccionados.value] // ✅ Enviar permisos como array plano

    console.log('Formulario enviado:', form)

    form.post('/sistema/usuarios', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            permisosSeleccionados.value = []
        }
    })
}
</script>