<template>
    <div class="wrapper">
        <!-- Header -->
        <header class="main-header">
            <a href="/" class="logo">
                <span class="logo-mini"><b>Sis</b></span>
                <span class="logo-lg"><b>Sistema</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" @click="toggleSidebar" role="button">
                    <span class="sr-only">Navegación</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li v-if="user" class="nav-item dropdown" style="position: relative">
                            <a href="#" class="nav-link" @click.prevent.stop="toggleDropdown">
                                <small class="bg-red">Online</small>
                                <span class="hidden-xs">{{ user.name }}</span>
                            </a>
                            <ul v-show="dropdownOpen" class="dropdown-menu" @click.stop>
                                <li>
                                    <a class="dropdown-item" href="#">Perfil</a>
                                </li>
                                <div class="logout-footer">
                                    <Link :href="route('logout')" method="post" class="nav-link text-danger">
                                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                                    </Link>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Layout principal -->
        <div class="main-body">
            <!-- Sidebar -->
            <aside class="main-sidebar">
                <div class="sidebar-inner">
                    <section class="sidebar-content">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <Link href="/dashboard" class="nav-link">
                                    <i class="fa fa-home"></i> Inicio
                                </Link>
                            </li>

                            <!-- Menú Gestión de Personal -->
                            <li class="nav-item">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                   @click.prevent="openPersonal = !openPersonal">
                                    <span><i class="fa fa-users"></i> Gestión de Personal</span>
                                    <i class="fa fa-angle-left" :class="{ 'rotate-icon-open': openPersonal }"></i>
                                </a>
                                <ul v-show="openPersonal" class="nav flex-column ms-3">
                                    <li  class="nav-item">
                                        <Link href="/sistema/personal_interno" class="nav-link">
                                            <i class="fa fa-circle-o"></i> Personal Interno
                                        </Link>
                                    </li>
                                    <li  class="nav-item">
                                        <Link href="/sistema/usuarios_lecturadores" class="nav-link">
                                            <i class="fa fa-circle-o"></i> Personal Lecturador
                                        </Link>
                                    </li>
                                    <li  class="nav-item">
                                        <Link href="/sistema/usuarios" class="nav-link">
                                            <i class="fa fa-circle-o"></i> Usuarios del Sistema
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <Link href="/sistema/organigrama" class="nav-link">
                                    <i class="fa fa-sitemap"></i> Organigrama
                                </Link>
                            </li>

                            <li  class="nav-item">
                                <Link href="/sistema/zonas_rutas" class="nav-link">
                                    <i class="fa fa-map"></i> Zonas y Rutas
                                </Link>
                            </li>

                            <li class="nav-item">
                                <Link href="/sistema/predios" class="nav-link">
                                    <i class="fa fa-home"></i> Predios
                                </Link>
                            </li>

                            <li  class="nav-item">
                                <Link href="/sistema/instalaciones" class="nav-link">
                                    <i class="fa fa-cogs"></i> Instalaciones
                                </Link>
                            </li>

                            <li class="nav-item">
                                <Link href="/sistema/lecturadores" class="nav-link">
                                    <i class="fa fa-address-card"></i> Asignaciones
                                </Link>
                            </li>

                            <!-- Menú Configuración de Módulos -->
                            <li class="nav-item">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                   @click.prevent="openConfiguracion = !openConfiguracion">
                                    <span><i class="fa fa-cogs"></i> Configuración de Módulos</span>
                                    <i class="fa fa-angle-left" :class="{ 'rotate-icon-open': openConfiguracion }"></i>
                                </a>
                                <ul v-show="openConfiguracion" class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <Link href="/sistema/modulos/create" class="nav-link">
                                            <i class="fa fa-cog"></i> Crear Modulo
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link href="/sistema/modulos" class="nav-link">
                                            <i class="fa fa-cog"></i> Asignar programa
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link href="/sistema/modulos/modificar" class="nav-link">
                                            <i class="fa fa-cog"></i> Modificar
                                        </Link>
                                    </li>
                                    <li class="nav-item">
                                        <Link href="/sistema/modulos/eliminar" class="nav-link">
                                            <i class="fa fa-cog"></i> Eliminar
                                        </Link>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </section>

                    <!-- Logout abajo -->
                    <div class="logout-footer">
                        <Link :href="route('logout')" method="post" class="nav-link text-danger">
                            <i class="fa fa-sign-out"></i> Cerrar Sesión
                        </Link>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="content-wrapper">
                <section class="content">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth.user;
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? [];

const dropdownOpen = ref(false);
const openPersonal = ref(false);
const openConfiguracion = ref(false);

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value;
}

const sidebarCollapsed = ref(false);
function toggleSidebar() {
    sidebarCollapsed.value = !sidebarCollapsed.value;
}

function closeDropdown(event) {
    const dropdown = document.querySelector(".nav-item.dropdown");
    if (dropdown && !dropdown.contains(event.target)) {
        dropdownOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener("click", closeDropdown);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>

<style scoped>
html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
}

.wrapper {
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}

.main-body {
    display: flex;
    flex: 1;
    height: 100%;
    overflow: hidden;
}

.sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
}

.nav-link {
    color: #d1d5db;
    padding: 8px 12px;
    display: block;
    text-decoration: none;
}

.nav i {
    margin-right: 8px;
    color: inherit;
}

.content-wrapper {
    flex: 1;
    height: 100%;
    overflow-y: auto;
    padding: 1rem;
}

.main-sidebar {
    width: 250px;
    background-color: #1f2937;
    color: #f9fafb;
    flex-shrink: 0;
    border-right: 1px solid #374151;
    height: 100vh;
}

.sidebar-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.sidebar-content {
    overflow-y: auto;
    padding: 1rem;
    flex-grow: 1;
}

.logout-footer {
    margin-top: auto;
    padding: 1rem;
    text-align: center;
    border-top: 1px solid #374151;
    background-color: #111827;
}

.logout-footer .nav-link {
    color: #f87171;
    text-decoration: none;
}

.logout-footer .nav-link:hover {
    background-color: #b91c1c;
    color: #fff !important;
}

/* Icon rotation */
.rotate-icon {
    transition: transform 0.2s ease-in-out;
}
.rotate-icon-open {
    transform: rotate(-90deg);
}
</style>
