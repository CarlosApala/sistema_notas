<template>
    <div class="container mx-auto p-4 max-w-5xl">
        <h1 class="text-2xl font-bold mb-4">Registrar Zonas</h1>



        <TablaBusqueda titulo="Lista de Zonas" fetch-url="/nLecturaMovil/api/zonas" :columnas="columnas" :per-page="10"
            @onRowClick="handleRowClick">
        </TablaBusqueda>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'
import App from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

console.log('mostrar datos');
console.log(permissions);
defineOptions({ layout: App })
const columnas = [
    { key: 'NombreZona', label: 'Nombre' },
]

// Manejo del clic en fila, si quieres navegar o mostrar detalles
function handleRowClick(user) {
    // Por ejemplo, ir a la vista detalle del usuario:
    router.visit(`/nLecturaMovil/sistema/zonas/${user.id}`)
}

</script>
