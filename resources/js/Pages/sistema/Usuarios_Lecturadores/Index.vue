<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Lecturadores
            <span v-if="filters.deleted">(eliminados)</span>
        </h1>

        <div v-if="flash.success" class="alert alert-success mb-4">
            {{ flash.success }}
        </div>

        <div class="d-flex justify-between align-items-center mb-4 flex-wrap gap-2">
            <form @submit.prevent="buscar" class="d-flex gap-2 flex-wrap">
                <input v-model="filters.search" type="text" placeholder="Buscar por nombre, email o username..."
                    class="form-control" />
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <Link v-if="permissions.includes('lecturadores.create')" href="/sistema/usuarios_lecturadores/create"
                    class="btn btn-success">
                Nuevo Lecturador
                </Link>

                <Link v-if="permissions.includes('lecturadores.view_deleted')"
                    :href="filters.deleted ? '/sistema/usuarios_lecturadores' : '/sistema/usuarios_lecturadores?deleted=true'"
                    class="btn btn-secondary">
                {{ filters.deleted ? 'Ver Activos' : 'Ver Eliminados' }}
                </Link>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Username</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="usuario in usuarios.data" :key="usuario.id" class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ usuario.id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ usuario.name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ usuario.email }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ usuario.username }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center space-x-2 whitespace-nowrap">
                            <template v-if="filters.deleted">
                                <button v-if="permissions.includes('lecturadores.restore')"
                                    @click="restaurar(usuario.id)"
                                    class="btn btn-success btn-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                    Restaurar
                                </button>
                            </template>
                            <template v-else>

                                <button v-if="permissions.includes('lecturadores.delete')" @click="eliminar(usuario.id)"
                                    class="btn btn-danger btn-sm px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Eliminar
                                </button>
                            </template>
                        </td>
                    </tr>

                    <tr v-if="usuarios.data.length === 0">
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            No se encontraron registros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav class="mt-4 flex justify-center">
            <ul class="pagination">
                <li v-for="(link, index) in usuarios.links" :key="index"
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
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []
defineOptions({ layout: App })

const { usuarios: initialUsuarios, filters: initialFilters, flash } = defineProps({
    usuarios: Object,
    filters: Object,
    flash: Object,
})

const filters = ref({ ...initialFilters })

let timeout = null
watch(() => filters.value.search, () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get('/sistema/usuarios_lecturadores', filters.value, {
            preserveState: true,
            replace: true,
        })
    }, 500)
})

function buscar() {
    router.get('/sistema/usuarios_lecturadores', filters.value, {
        preserveState: true,
        replace: true,
    })
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el registro',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/sistema/usuarios_lecturadores/${id}`, {
                preserveState: true,
            })
        }
    })
}

function restaurar(id) {
    Swal.fire({
        title: '¿Restaurar registro?',
        text: '¿Estás seguro que deseas restaurar este registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(`/sistema/usuarios_lecturadores/${id}/restore`, {}, {
                preserveState: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Restaurado',
                        text: 'El registro ha sido restaurado correctamente.',
                        icon: 'success',
                    }).then(() => {
                        router.get('/sistema/usuarios_lecturadores', { deleted: true }, {
                            preserveState: false,
                            replace: true,
                        })
                    })
                },
                onError: () => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al restaurar el registro.',
                        icon: 'error',
                    })
                }
            })
        }
    })
}

function paginar(url) {
    try {
        const u = new URL(url, window.location.origin)
        const relative = u.pathname + u.search
        router.get(relative, {}, { preserveState: true, replace: true })
    } catch (e) {
        console.error("Error al parsear URL de paginación:", url)
    }
}
</script>

<style scoped>
table th,
table td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

table th {
    max-width: none;
}
</style>
