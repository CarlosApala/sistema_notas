<template>
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4">Usuarios del Sistema</h1>

        <tabla-busqueda
            titulo="Lista de Usuarios"
            fetch-url="/api/usuarios"
            :columnas="columnas"
            :per-page="10"
            @onRowClick="handleRowClick">

            <template #row="{ item }">
                <td class="p-2 border">{{ item.name }}</td>
                <td class="p-2 border">{{ item.email }}</td>
                <td class="p-2 border">{{ item.username }}</td>
                <td class="p-2 border space-x-2">
                    <Link :href="`/sistema/usuarios/${item.id}`"
                        class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                        @click.stop>
                        Ver
                    </Link>

                    <Link v-if="permissions.includes('usuarios.editar')"
                        :href="`/sistema/usuarios/${item.id}/edit`"
                        class="btn btn-warning btn-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        @click.stop>
                        Editar
                    </Link>
                </td>
            </template>
        </tabla-busqueda>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

defineOptions({ layout: App })

const columnas = [
    { key: 'name', label: 'Nombre' },
    { key: 'email', label: 'Email' },
    { key: 'username', label: 'Usuario' },
]

function handleRowClick(user) {
    router.visit(`/sistema/usuarios/${user.id}`)
}
</script>
