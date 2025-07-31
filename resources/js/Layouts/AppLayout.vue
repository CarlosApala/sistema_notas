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

                            <!-- Inicio -->
                            <li class="nav-item">
                                <Link href="/dashboard" class="nav-link">
                                <i class="fa fa-home"></i> Inicio
                                </Link>
                            </li>

                            <!-- Personal Interno -->
                            <li class="nav-item" v-if="permisosPorModulo.personal_interno.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('personal_interno')">
                                    <span><i class="fa fa-users"></i> Personal Interno</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.personal_interno }"></i>
                                </a>
                                <ul v-show="openMenus.personal_interno" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('personal_interno.crear')">
                                        <Link href="/sistema/personal_interno/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear Personal
                                        </Link>
                                    </li>
                                    <li >
                                        <Link href="/sistema/personal_interno" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('personal_interno.editar')">
                                        <Link href="/sistema/personal_interno/editar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Editar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('personal_interno.eliminar')">
                                        <Link href="/sistema/personal_interno/eliminar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>


                            <!-- Usuarios de sistema -->
                            <li class="nav-item" v-if="permisosPorModulo.usuarios.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('usuarios')">
                                    <span><i class="fa fa-users"></i> Usuarios de Sistema</span>
                                    <i class="fa fa-angle-left" :class="{ 'rotate-icon-open': openMenus.usuarios }"></i>
                                </a>
                                <ul v-show="openMenus.usuarios" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('usuarios.crear')">
                                        <Link href="/sistema/usuarios/create" class="nav-link"><i
                                            class="fa fa-circle-o"></i> Crear Usuario</Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/usuarios" class="nav-link"><i class="fa fa-circle-o"></i>
                                        Buscar</Link>
                                    </li>
                                    <li v-if="tienePermiso('usuarios.editar')">
                                        <Link href="/sistema/usuarios/editar" class="nav-link"><i
                                            class="fa fa-circle-o"></i> Editar</Link>
                                    </li>
                                    <li v-if="tienePermiso('usuarios.eliminar')">
                                        <Link href="/sistema/usuarios/delete" class="nav-link"><i
                                            class="fa fa-circle-o"></i> Eliminar</Link>
                                    </li>
                                </ul>
                            </li>

                            <!-- Personal lecturador -->
                            <li class="nav-item" v-if="permisosPorModulo.lecturadores.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('lecturadores')">
                                    <span><i class="fa fa-users"></i> Lecturadores</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.lecturadores }"></i>
                                </a>
                                <ul v-show="openMenus.lecturadores" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('lecturadores.crear')">
                                        <Link href="/sistema/usuarios_lecturadores/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear Personal
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/usuarios_lecturadores" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>

                                    <li v-if="tienePermiso('lecturadores.eliminar')">
                                        <Link href="/sistema/usuarios_lecturadores/eliminar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>




                            <!-- Otros enlaces planos -->
                            <!-- <li class="nav-item">
                                <Link href="/sistema/organigrama" class="nav-link"><i class="fa fa-sitemap"></i>
                                Organigrama</Link>
                            </li> -->

                            <!-- Zonas -->
                            <li class="nav-item" v-if="permisosPorModulo.zona.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('zona')">
                                    <span><i class="fa fa-users"></i> Zonas</span>
                                    <i class="fa fa-angle-left" :class="{ 'rotate-icon-open': openMenus.zona }"></i>
                                </a>
                                <ul v-show="openMenus.zona" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('zona.crear')">
                                        <Link href="/sistema/zonas/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear zonas
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/zonas" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('zona.editar')">
                                        <Link href="/zonas-editar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Editar
                                        </Link>
                                    </li>

                                    <li v-if="tienePermiso('zona.eliminar')">
                                        <Link href="/zonas-eliminar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                            <!-- Zonas y Rutas -->
                            <li class="nav-item" v-if="permisosPorModulo.zona_ruta.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('zona_ruta')">
                                    <span><i class="fa fa-users"></i> Zonas y Rutas</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.zona_ruta }"></i>
                                </a>
                                <ul v-show="openMenus.zona_ruta" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('zona_ruta.crear')">
                                        <Link href="/sistema/rutas/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear ruta
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/rutas" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('zona_ruta.editar')">
                                        <Link href="/sistema/rutas/editar-rutas" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Editar
                                        </Link>
                                    </li>

                                    <li v-if="tienePermiso('zona_ruta.eliminar')">
                                        <Link href="/sistema/rutas/eliminar-rutas" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <!-- Predios -->
                            <li class="nav-item" v-if="permisosPorModulo.predios.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('predios')">
                                    <span><i class="fa fa-users"></i> Predios</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.predios }"></i>
                                </a>
                                <ul v-show="openMenus.predios" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('predios.crear')">
                                        <Link href="/sistema/predios/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear predio
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/predios/index" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('predios.editar')">
                                        <Link href="/sistema/predios/editar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Editar
                                        </Link>
                                    </li>

                                    <li v-if="tienePermiso('predios.eliminar')">
                                        <Link href="/sistema/predios/eliminar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <!-- Instalaciones -->
                            <li class="nav-item" v-if="permisosPorModulo.instalaciones.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('instalaciones')">
                                    <span><i class="fa fa-users"></i> instalaciones</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.instalaciones }"></i>
                                </a>
                                <ul v-show="openMenus.instalaciones" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('instalaciones.crear')">
                                        <Link href="/sistema/instalaciones/create" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Crear instalaciones
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/instalaciones/index" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Buscar
                                        </Link>
                                    </li>
                                    <li v-if="tienePermiso('instalaciones.editar')">
                                        <Link href="/sistema/instalaciones/editar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Editar
                                        </Link>
                                    </li>

                                    <li v-if="tienePermiso('instalaciones.eliminar')">
                                        <Link href="/sistema/instalaciones/eliminar" class="nav-link">
                                        <i class="fa fa-circle-o"></i> Eliminar
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <!-- <li class="nav-item">
                                <Link href="/sistema/zonas_rutas" class="nav-link"><i class="fa fa-map"></i> Zonas y
                                Rutas</Link>
                            </li> -->
                            <li class="nav-item" v-if="permisosPorModulo.asignaciones.value">
                                <Link href="/sistema/lecturadores" class="nav-link"><i class="fa fa-address-card"></i>
                                Asignaciones</Link>
                            </li>

                            <!-- Configuración de Módulos -->
                            <li class="nav-item" v-if="permisosPorModulo.configuracion.value">
                                <a href="#" class="nav-link d-flex justify-content-between align-items-center"
                                    @click.prevent="toggleMenu('configuracion')">
                                    <span><i class="fa fa-cogs"></i> Configuración de Módulos</span>
                                    <i class="fa fa-angle-left"
                                        :class="{ 'rotate-icon-open': openMenus.configuracion }"></i>
                                </a>
                                <ul v-show="openMenus.configuracion" class="nav flex-column ms-3">
                                    <li v-if="tienePermiso('configuracion.crear')">
                                        <Link href="/sistema/modulos/create" class="nav-link"><i class="fa fa-cog"></i>
                                        Crear Módulo</Link>
                                    </li>
                                    <li>
                                        <Link href="/sistema/modulos" class="nav-link"><i class="fa fa-cog"></i> Asignar
                                        Programa</Link>
                                    </li>
                                    <li v-if="tienePermiso('configuracion.editar')">
                                        <Link href="/sistema/modulos/modificar" class="nav-link"><i
                                            class="fa fa-cog"></i> Modificar</Link>
                                    </li>
                                    <li v-if="tienePermiso('configuracion.eliminar')">
                                        <Link href="/sistema/modulos/eliminar" class="nav-link"><i
                                            class="fa fa-cog"></i> Eliminar</Link>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </section>

                    <!-- Logout -->
                    <div class="logout-footer">
                        <Link :href="route('logout')" method="post" class="nav-link text-danger">
                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                        </Link>
                    </div>
                </div>
            </aside>

            <!-- Contenido -->
            <div class="content-wrapper">
                <section class="content">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted,computed, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user
const permissions = page.props.auth?.user?.permissions ?? page.props.permissions ?? []

console.log('mostrar los permisos')
console.log(permissions)
const dropdownOpen = ref(false)
const sidebarCollapsed = ref(false)
const openMenus = ref({})

// Menús colapsables por key
const menuKeys = ['usuarios', 'personal', 'configuracion', 'personal_interno', 'lecturadores', 'zona', 'zona_ruta','predios','instalaciones','asignaciones']
//const modulo=menuKeys;

const tienePermisosDelModulo = (modulo) =>
  permissions.some((p) => p.startsWith(`${modulo}.`));

const permisosPorModulo = Object.fromEntries(
  menuKeys.map((m) => [m, computed(() => tienePermisosDelModulo(m))])
);

const tienePermiso = (permiso) =>
  permissions.includes(permiso);

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value
}

function toggleSidebar() {
    sidebarCollapsed.value = !sidebarCollapsed.value
}

function toggleMenu(menu) {
    openMenus.value[menu] = !openMenus.value[menu]
}

function closeDropdown(event) {
    const dropdown = document.querySelector('.nav-item.dropdown')
    if (dropdown && !dropdown.contains(event.target)) {
        dropdownOpen.value = false
    }
}

onMounted(() => {
    // Inicializamos los menús cerrados
    menuKeys.forEach((key) => {
        openMenus.value[key] = false
    })

    document.addEventListener('click', closeDropdown)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', closeDropdown)
})
</script>
<style>
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
