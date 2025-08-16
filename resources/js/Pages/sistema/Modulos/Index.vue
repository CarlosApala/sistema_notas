<script setup>
import TablaBusqueda from "@/Components/TablaBusqueda.vue";
import App from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({ layout: App });

const columnas = [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "descripcion", label: "Descripción" },
];

const props = defineProps({
    modulos: Object,
});

const fetchUrl = route("api.modulos");

function asignarPrograma(id) {
    Inertia.visit(route("modulos.asignar", { id }));
}
</script>

<template>
    <TablaBusqueda
        :titulo="'Listado de Módulos'"
        :fetchUrl="fetchUrl"
        :columnas="columnas"
        :perPage="10"
    >
        <template #row="{ item }">
            <td class="p-2 border">{{ item.id }}</td>
            <td class="p-2 border">{{ item.nombre }}</td>
            <td class="p-2 border">{{ item.descripcion }}</td>
            <td class="p-2 border space-x-2">
                <Link
                    :href="`/nLecturaMovil/sistema/modulos/${item.id}/asignarPrograma`"
                    class="btn btn-info btn-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click.stop
                >
                    Asingar Programas
                </Link>
            </td>
        </template>
    </TablaBusqueda>
</template>
