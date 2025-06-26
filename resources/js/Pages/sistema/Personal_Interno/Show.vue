<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detalle de Personal Interno</h1>

        <Link href="/sistema/personal_interno" class="btn btn-secondary mb-4">
            Volver al listado
        </Link>

        <div class="card border border-gray-300 rounded p-4 shadow">
            <div class="flex flex-wrap gap-8">
                <!-- Columna: Información Personal -->
                <div class="w-full md:w-1/2 space-y-4">
                    <h2 class="text-lg font-semibold mb-2">Información Personal</h2>
                    <p><strong>ID:</strong> {{ persona.id }}</p>
                    <p><strong>Nombres:</strong> {{ persona.nombres || '-' }}</p>
                    <p><strong>Apellidos:</strong> {{ persona.apellidos || '-' }}</p>
                    <p><strong>Carnet de Identidad:</strong> {{ persona.carnet_identidad || '-' }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ persona.fecha_nacimiento || '-' }}</p>
                    <p><strong>Género:</strong> {{ persona.genero || '-' }}</p>
                    <p><strong>Lugar de Nacimiento:</strong> {{ persona.lugar_nacimiento || '-' }}</p>
                    <p><strong>Nacionalidad:</strong> {{ persona.nacionalidad || '-' }}</p>
                </div>

                <!-- Columna: Información de Contacto y Registro -->
                <div class="w-full md:w-1/2 space-y-4">
                    <h2 class="text-lg font-semibold mb-2">Información de Contacto y Registro</h2>
                    <p><strong>Dirección:</strong> {{ persona.direccion || '-' }}</p>
                    <p><strong>Email:</strong> {{ persona.email || '-' }}</p>
                    <p><strong>Número de Celular:</strong> {{ persona.numero_celular || '-' }}</p>
                    <p><strong>Creado en:</strong> {{ persona.created_at || '-' }}</p>
                    <p><strong>Actualizado en:</strong> {{ persona.updated_at || '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const props = defineProps({
    persona: Object,
})
</script>
