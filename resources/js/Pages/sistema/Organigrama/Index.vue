<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Organigrama Institucional</h1>
        <div id="organigrama" class="organigrama-container"></div>
    </div>
</template>

<script setup>
import OrgChart from "@balkangraph/orgchart.js"
import { onMounted } from "vue"
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

onMounted(() => {
    const chart = new OrgChart(document.getElementById("organigrama"), {
        nodeBinding: {
            field_0: "name",
            field_1: "title"
        },
        nodes: [
            { id: 1, name: "Carlos", title: "Director General" },
            { id: 2, pid: 1, name: "Ana", title: "Subdirectora Ejecutiva" },
            { id: 11, stpid: 1, name: "Patricia", title: "Asistente Ejecutiva" },
            { id: 3, pid: 2, name: "Luis", title: "Gerente de Finanzas" },
            { id: 4, pid: 2, name: "Marta", title: "Gerente de Recursos Humanos" },
            { id: 5, pid: 3, name: "Pedro", title: "Analista Financiero" },
            { id: 6, pid: 4, name: "Lucía", title: "Especialista en RRHH" },
            { id: 9, pid: 4, name: "Javier", title: "Coordinador de Capacitación" },
            { id: 10, pid: 4, name: "Sofía", title: "Jefa de Relaciones Laborales" },
            { id: 7, pid: 5, name: "Andrés", title: "Asistente Contable" },
            { id: 8, pid: 6, name: "María", title: "Pasante de RRHH" }
        ],

        enableZoom: false,         // ❌ Desactiva zoom
        scaleInitial: OrgChart.match.boundary, // 🔄 Escala automáticamente para que quepa en pantalla
        layout: OrgChart.tree,     // Layout estándar tipo árbol
        centerOnResize: true       // ✅ Centra automáticamente en cambios de tamaño
    });
});

</script>

<style scoped>
.organigrama-container {
    width: 100%;
    height: 60vh;
    /* Ajusta si tu header/footer ocupan más o menos espacio */
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: auto;
}
</style>
