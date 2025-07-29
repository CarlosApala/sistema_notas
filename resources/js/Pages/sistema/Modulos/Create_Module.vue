<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import FormSection from "@/Components/FormSection.vue";
import App from "@/Layouts/AppLayout.vue";

defineOptions({ layout: App });

const form = useForm({
    nombre: "",
    descripcion: "",
});

const page = usePage();
const flashMessage = computed(() => page.props.flash?.success);

function handleSubmit() {
    form.post("/sistema/modulos", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>
    <div class="w-full flex justify-center mt-10 px-4">
        <div class="w-full max-w-2xl">
            <!-- Mensaje de éxito -->
            <div v-if="flashMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ flashMessage }}
            </div>

            <FormSection @submitted="handleSubmit">
                <template #title> Crear Módulo </template>

                <template #form>
                    <div class="col-start-1 col-end-7 space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input v-model="form.nombre" type="text" id="nombre" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            <span v-if="form.errors.nombre" class="text-red-500 text-xs">{{ form.errors.nombre }}</span>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <input v-model="form.descripcion" type="text" id="descripcion" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                            <span v-if="form.errors.descripcion" class="text-red-500 text-xs">{{ form.errors.descripcion }}</span>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700" :disabled="form.processing">
                        Guardar
                    </button>
                </template>
            </FormSection>
        </div>
    </div>
</template>
