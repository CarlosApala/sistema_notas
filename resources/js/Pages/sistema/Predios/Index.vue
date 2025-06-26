<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Predios <span v-if="filters.deleted">(eliminados)</span>
        </h1>

        <div v-if="flash.success" class="alert alert-success mb-4">{{ flash.success }}</div>

        <!-- Filtros -->
        <div class="d-flex justify-between align-items-center mb-4 flex-wrap gap-2">
            <form @submit.prevent="buscar" class="d-flex gap-2 flex-wrap">
                <input v-model="filters.search" type="text" placeholder="Buscar por dirección, barrio o distrito" class="form-control" />
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <Link href="/sistema/predios/create" class="btn btn-success">Registrar Predio</Link>
                <Link
                    :href="filters.deleted ? '/sistema/predios' : '/sistema/predios?deleted=true'"
                    class="btn btn-secondary"
                >
                    {{ filters.deleted ? 'Ver Activos' : 'Ver Eliminados' }}
                </Link>
            </div>
        </div>

        <!-- Tabla -->
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Dirección</th>
                    <th class="border px-4 py-2 text-left">Zona/Barrio</th>
                    <th class="border px-4 py-2 text-left">Distrito</th>
                    <th class="border px-4 py-2 text-left">Creado</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="predio in predios.data" :key="predio.id" class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ predio.id }}</td>
                    <td class="border px-4 py-2">{{ predio.direccion || '-' }}</td>
                    <td class="border px-4 py-2">{{ predio.zonaBarrio || '-' }}</td>
                    <td class="border px-4 py-2">{{ predio.distrito || '-' }}</td>
                    <td class="border px-4 py-2">{{ predio.created_at }}</td>
                    <td class="border px-4 py-2 text-center space-x-2">
                        <template v-if="filters.deleted">
                            <button @click="restaurar(predio.id)" class="btn btn-success btn-sm">Restaurar</button>
                        </template>
                        <template v-else>
                            <Link :href="`/sistema/predios/${predio.id}`" class="btn btn-info btn-sm">Ver</Link>
                            <Link :href="`/sistema/predios/${predio.id}/edit`" class="btn btn-warning btn-sm">Editar</Link>
                            <button @click="eliminar(predio.id)" class="btn btn-danger btn-sm">Eliminar</button>
                        </template>
                    </td>
                </tr>
                <tr v-if="predios.data.length === 0">
                    <td colspan="6" class="text-center p-4 text-gray-500">No se encontraron predios.</td>
                </tr>
            </tbody>
        </table>

        <!-- Paginación -->
        <nav class="mt-4 flex justify-center" v-if="predios.links?.length">
            <ul class="pagination">
                <li
                    v-for="(link, index) in predios.links"
                    :key="index"
                    :class="['page-item', { disabled: !link.url, active: link.active }]"
                >
                    <a
                        v-if="link.url"
                        href="#"
                        class="page-link"
                        @click.prevent="paginar(link.url)"
                        v-html="link.label"
                    ></a>
                    <span v-else class="page-link" v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
    import App from '@/Layouts/AppLayout.vue'

    defineOptions({ layout: App })

const { predios, filters: initialFilters, flash } = defineProps({
    predios: Object,
    filters: Object,
    flash: Object,
})

const filters = ref({ ...initialFilters })

// Búsqueda con debounce
let timeout = null
watch(() => filters.value.search, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get('/sistema/predios', filters.value, {
            preserveState: true,
            replace: true,
        })
    }, 500)
})

function buscar() {
    router.get('/sistema/predios', filters.value, {
        preserveState: true,
        replace: true,
    })
}

function paginar(url) {
    try {
        const u = new URL(url, window.location.origin)
        const relative = u.pathname + u.search
        router.get(relative, {}, { preserveState: true, replace: true })
    } catch (e) {
        console.error('Error al parsear URL de paginación:', url)
    }
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el predio.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/predios/${id}`, { preserveState: true })
        }
    })
}

function restaurar(id) {
    Swal.fire({
        title: '¿Restaurar predio?',
        text: '¿Estás seguro que deseas restaurar este predio?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/sistema/predios/${id}/restore`, {}, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire('Restaurado', 'El predio ha sido restaurado correctamente.', 'success')
                    router.get('/sistema/predios', {
                        deleted: true,
                        search: filters.value.search || '',
                    }, {
                        preserveState: true,
                        replace: true,
                    })
                },
                onError: () => {
                    Swal.fire('Error', 'Ocurrió un error al restaurar el predio.', 'error')
                }
            })
        }
    })
}
</script>
