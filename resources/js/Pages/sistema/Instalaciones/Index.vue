<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Instalaciones
            <span v-if="filters.deleted">(eliminadas)</span>
        </h1>

        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <form @submit.prevent="buscar" class="d-flex gap-2 flex-wrap">
                <input v-model="filters.search" type="text" placeholder="Buscar por medidor o predio..."
                    class="form-control" />
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <Link href="/sistema/instalaciones/create" class="btn btn-success">Nueva Instalación</Link>
                <Link :href="filters.deleted ? '/sistema/instalaciones' : '/sistema/instalaciones?deleted=true'"
                    class="btn btn-secondary">
                    {{ filters.deleted ? 'Ver Activas' : 'Ver Eliminadas' }}
                </Link>
            </div>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Predio</th>
                    <th class="border px-4 py-2 text-left">Medidor</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="instalacion in instalaciones.data" :key="instalacion.id" class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ instalacion.id }}</td>
                    <!-- Aquí muestro algo representativo del predio, como su dirección -->
                    <td class="border px-4 py-2">{{ instalacion.predio?.direccion || 'Sin dirección' }}</td>
                    <td class="border px-4 py-2">{{ instalacion.NumeroMedidor || '-' }}</td>
                    <td class="border px-4 py-2 text-center space-x-2">
                        <template v-if="filters.deleted">
                            <button @click="restaurar(instalacion.id)"
                                class="btn btn-success btn-sm px-3 py-1">Restaurar</button>
                        </template>
                        <template v-else>
                            <Link :href="`/sistema/instalaciones/${instalacion.id}`"
                                class="btn btn-info btn-sm px-3 py-1">Ver</Link>
                            <Link :href="`/sistema/instalaciones/${instalacion.id}/edit`"
                                class="btn btn-warning btn-sm px-3 py-1">Editar</Link>
                            <button @click="eliminar(instalacion.id)" class="btn btn-danger btn-sm px-3 py-1">
                                Eliminar
                            </button>
                        </template>
                    </td>
                </tr>

                <tr v-if="instalaciones.data.length === 0">
                    <td colspan="6" class="text-center p-4 text-gray-500">No se encontraron instalaciones.</td>
                </tr>
            </tbody>
        </table>

        <nav class="mt-4 flex justify-center">
            <ul class="pagination">
                <li v-for="(link, index) in instalaciones.links" :key="index"
                    :class="['page-item', { disabled: !link.url, active: link.active }]">
                    <a v-if="link.url" href="#" class="page-link" @click.prevent="paginar(link.url)"
                        v-html="link.label"></a>
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'
import { ref, watch } from 'vue'

defineOptions({ layout: App })

const { instalaciones, filters: initialFilters, flash } = defineProps({
    instalaciones: Object,
    filters: Object,
    flash: Object,
})

const filters = ref({ ...initialFilters })

let timeout = null
watch(() => filters.value.search, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get('/sistema/instalaciones', filters.value, {
            preserveState: true,
            replace: true,
        })
    }, 500)
})

function buscar() {
    router.get('/sistema/instalaciones', filters.value, {
        preserveState: true,
        replace: true,
    })
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará la instalación.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/instalaciones/${id}`, {
                preserveState: true,
            })
        }
    })
}

function restaurar(id) {
    Swal.fire({
        title: '¿Restaurar instalación?',
        text: '¿Estás seguro que deseas restaurarla?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/sistema/instalaciones/${id}/restore`, {}, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire('Restaurada', 'La instalación ha sido restaurada.', 'success')
                },
                onError: () => {
                    Swal.fire('Error', 'No se pudo restaurar la instalación.', 'error')
                }
            })
        }
    })
}

function paginar(url) {
    router.get(url, {}, { preserveState: true, replace: true })
}
</script>

<style scoped>
/* Puedes añadir tus estilos personalizados aquí */
</style>
