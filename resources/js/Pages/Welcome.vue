<template>
    <section class="vh-100 d-flex align-items-center justify-content-center" style="background-color: #1B396A;">
        <div class="container text-center text-white">
            <div class="mb-4">
                <img src="/assets/img/LogoCOSMOL.jpg" class="img-fluid mx-auto d-block" style="max-width: 250px;"
                    alt="Logo del Sistema" />
            </div>
            <h1 class="display-5 fw-bold mb-3">Bienvenido al Sistema de Lecturación</h1>
            <p class="lead">
                Este sistema está diseñado para la gestión de personal, cargos y dependencias, facilitando el control
                institucional y la organización jerárquica.
            </p>
            <p class="fw-semibold">Por favor, inicie sesión para acceder a las funcionalidades del sistema.</p>

            <Link :href="route('login')" class="btn btn-light mt-4 px-4 py-2 fw-semibold">
            Iniciar Sesión
            </Link>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
