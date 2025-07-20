<template>
    <div class="wrapper">
        <!-- Header -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
                        <li v-if="user" class="nav-item dropdown" style="position: relative;">
                            <a href="#" class="nav-link" role="button" @click.prevent.stop="toggleDropdown"
                               :aria-expanded="dropdownOpen.toString()">
                                <small class="bg-red">Online</small>
                                <span class="hidden-xs">{{ user.name }}</span>
                            </a>

                            <ul v-show="dropdownOpen" class="dropdown-menu"
                                style="position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ccc; min-width: 150px; padding: 0.5rem 0; box-shadow: 0 2px 5px rgba(0,0,0,0.15); z-index: 1000;"
                                @click.stop>
                                <li><a class="dropdown-item" href="#">Perfil</a></li>
                                <li>
                                    <Link :href="route('logout')" method="post" as="button"
                                          class="btn btn-danger dropdown-item" style="width: 100%; text-align: left;">
                                        Cerrar Sesión
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Sidebar -->
        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <Link href="/dashboard" class="nav-link">
                            <i class="fa fa-home"></i> Inicio
                        </Link>
                    </li>

                    <!-- Collapse / Accordion para Gestión de Personal -->
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                           @click.prevent.stop="open = !open">
                            <span><i class="fa fa-users"></i> Gestión de Personal</span>
                            <i class="fa fa-angle-left rotate-icon" :class="{ 'rotate-icon-open': open }"></i>
                        </a>
                        <ul v-show="open" class="nav flex-column ms-3">
                            <li v-if="permissions.includes('personal_interno.view')" class="nav-item">
                                <Link href="/sistema/personal_interno" class="nav-link">
                                    <i class="fa fa-circle-o"></i> Personal Interno
                                </Link>
                            </li>
                            <li v-if="permissions.includes('lecturadores.view')" class="nav-item">
                                <Link href="/sistema/usuarios_lecturadores" class="nav-link">
                                    <i class="fa fa-circle-o"></i> Personal Lecturador
                                </Link>
                            </li>
                            <li v-if="permissions.includes('usuarios.view')" class="nav-item">
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

                    <li v-if="permissions.includes('zona.index')" class="nav-item">
                        <Link href="/sistema/zonas_rutas" class="nav-link">
                            <i class="fa fa-map"></i> Zonas y Rutas
                        </Link>
                    </li>
                    <li v-if="permissions.includes('predios.index')" class="nav-item">
                        <Link href="/sistema/predios" class="nav-link">
                            <i class="fa fa-home"></i> Predios
                        </Link>
                    </li>
                    <li v-if="permissions.includes('instalaciones.index')" class="nav-item">
                        <Link href="/sistema/instalaciones" class="nav-link">
                            <i class="fa fa-cogs"></i> Instalaciones
                        </Link>
                    </li>
                    <li v-if="permissions.includes('asignaciones.view')" class="nav-item">
                        <Link href="/sistema/lecturadores" class="nav-link">
                            <i class="fa fa-address-card"></i> Asignaciones
                        </Link>
                    </li>

                    <!-- <li class="nav-item">
                        <Link href="/contabilidad" class="nav-link">
                            <i class="fa fa-calculator"></i> Contabilidad
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/comercial" class="nav-link">
                            <i class="fa fa-shopping-cart"></i> Comercial
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/tecnico" class="nav-link">
                            <i class="fa fa-wrench"></i> Técnico
                        </Link>
                    </li> -->
                    <li class="nav-item">
                        <Link :href="route('logout')" class="nav-link" method="post">
                            <i class="fa fa-sign-out"></i> Cerrar Sesión
                        </Link>
                    </li>
                </ul>
            </section>
        </aside>

        <!-- Main Content -->
        <div class="content-wrapper">
            <section class="content">
                <slot />
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs"><b>Versión</b> 1.0.0</div>
            <strong>Copyright &copy;</strong> Todos los derechos reservados.
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

const dropdownOpen = ref(false)
const open = ref(false)

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value
}

function closeDropdown(event) {
    const dropdown = document.querySelector('.nav-item.dropdown')
    if (dropdown && !dropdown.contains(event.target)) {
        dropdownOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', closeDropdown)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', closeDropdown)
})
</script>

<style scoped>
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
}

.wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.content-wrapper {
    flex: 1;
    padding: 1rem;
}

.main-footer {
    height: 10vh;
    flex-shrink: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1rem;
}

.rotate-icon {
    transition: transform 0.3s ease;
    display: inline-block;
}

.rotate-icon-open {
    transform: rotate(-90deg);
}

.nav-link {
    text-decoration: none !important;
}

.wrapper .main-sidebar {
    border: none !important;
}
</style>
