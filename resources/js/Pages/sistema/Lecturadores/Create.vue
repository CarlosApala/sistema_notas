    <template>
        <div class="container mx-auto p-4 grid grid-cols-2 gap-6">
            <!-- Columna izquierda: Formulario -->
            <div class="bg-white p-6 rounded shadow max-h-[500px]">
                <h1 class="text-2xl font-bold mb-6">Asignar Ruta</h1>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Input Ruta -->
                    <div>
                        <label for="ruta" class="block font-medium mb-1">Ruta</label>
                        <input id="ruta" type="text" readonly :value="selectedRuta ? selectedRuta.NombreRuta : ''"
                            placeholder="Haz clic para seleccionar ruta" @click="showTable('rutas')"
                            class="form-input w-full border rounded px-3 py-2 cursor-pointer" />
                        <p v-if="errors.idRuta" class="text-red-600 text-sm mt-1">{{ errors.idRuta }}</p>
                    </div>

                    <!-- Input Usuario -->
                    <div>
                        <label for="usuario" class="block font-medium mb-1">Lecturador</label>
                        <input id="usuario" type="text" readonly :value="selectedUsuario ? selectedUsuario.name : ''"
                            placeholder="Haz clic para seleccionar usuario" @click="showTable('usuarios')"
                            class="form-input w-full border rounded px-3 py-2 cursor-pointer" />
                        <p v-if="errors.idUser" class="text-red-600 text-sm mt-1">{{ errors.idUser }}</p>
                    </div>

                    <!-- Periodo -->
                    <div>
                        <label class="block font-medium mb-1">Periodo</label>
                        <div class="flex space-x-2">
                            <select v-model="selectedYear" class="form-select border rounded px-3 py-2 w-1/2">
                                <option disabled value="">Año</option>
                                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                            </select>
                            <select v-model="selectedMonth" class="form-select border rounded px-3 py-2 w-1/2">
                                <option disabled value="">Mes</option>
                                <option v-for="(name, index) in months" :key="index" :value="index + 1">
                                    {{ name }}
                                </option>
                            </select>
                        </div>
                        <p v-if="errors.periodo" class="text-red-600 text-sm mt-1">{{ errors.periodo }}</p>
                    </div>

                    <button type="submit"
                        class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2 flex items-center justify-center"
                        :disabled="processing">
                        <span v-if="processing" class="mr-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>
                        </span>
                        Guardar
                    </button>
                </form>
            </div>

            <!-- Columna derecha: Tabla dinámica -->
            <div class="bg-white p-6 rounded shadow max-h-[500px] overflow-auto">
                <template v-if="visibleTable === 'rutas'">
                    <TablaBusqueda titulo="Selecciona una Ruta" fetchUrl="/nLecturaMovil/api/rutas" :columnas="[
                        { key: 'id', label: 'ID' },
                        { key: 'NombreRuta', label: 'Nombre Ruta' }
                    ]" :onRowClick="selectRuta" :perPage="10" />
                </template>

                <template v-if="visibleTable === 'usuarios'">
                    <TablaBusqueda titulo="Selecciona un Usuario" fetchUrl="/nLecturaMovil/api/lecturadores" :columnas="[
                        { key: 'id', label: 'ID' },
                        { key: 'name', label: 'Nombre' },
                        { key: 'email', label: 'Email' }
                    ]" :onRowClick="selectUsuario" :perPage="10" />
                    <div class="text-center mt-2">
                        <Link href="/nLecturaMovil/sistema/usuarios_lecturadores" class="text-blue-600 hover:underline text-sm">
                        Ver Usuarios Lecturadores
                        </Link>
                    </div>
                </template>

                <div v-if="!visibleTable" class="text-gray-500 text-center py-4">
                    Haz clic en un input para mostrar la tabla correspondiente
                </div>
            </div>

        </div>
    </template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import App from '@/Layouts/AppLayout.vue'
import TablaBusqueda from '@/Components/TablaBusqueda.vue'


defineOptions({ layout: App })

const rutas = ref([])
const usuarios = ref([])
const searchRuta = ref('')
const loading = ref(true)
const visibleTable = ref(null) // 'rutas' o 'usuarios'

const form = ref({
    idRuta: '',     // 👈 exactamente como espera Laravel
    idUser: '',
    periodo: '',
})


const selectedRuta = ref(null)
const selectedUsuario = ref(null)

const errors = ref({})
const processing = ref(false)

const years = ref([])
const months = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
]

const selectedYear = ref('')
const selectedMonth = ref('')

watch([selectedYear, selectedMonth], ([newYear, newMonth]) => {
    if (newYear && newMonth) {
        const mm = newMonth.toString().padStart(2, '0')
        form.value.periodo = `${newYear}-${mm}`
    } else {
        form.value.periodo = ''
    }
})


const buscarRutas = async () => {
    try {
        const url = new URL('/nLecturaMovil/api/rutas', window.location.origin)
        url.searchParams.set('search', searchRuta.value)
        url.searchParams.set('per_page', 50)

        const response = await fetch(url)
        if (!response.ok) throw new Error('Error en la solicitud')

        const data = await response.json()
        rutas.value = data.data // si usas paginate()
    } catch (error) {
        console.error('Error al buscar rutas:', error)
    }
}

watch(searchRuta, () => {
    buscarRutas()
})


async function loadData() {
    loading.value = true
    try {
        const [rutasRes, usuariosRes] = await Promise.all([
            fetch('/nLecturaMovil/api/rutas'),
            fetch('/nLecturaMovil/api/lecturadores'),
        ])

        if (!rutasRes.ok || !usuariosRes.ok) throw new Error('Error al cargar datos')

        const rutasJson = await rutasRes.json()
        rutas.value = rutasJson.data // Ajusta si usas paginación

        console.log(rutasJson)

        const usuariosJson = await usuariosRes.json()
        usuarios.value = usuariosJson.data || usuariosJson // Ajusta si usas paginación
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    // Llenar años desde 2020 a 2030 (puedes ajustar rango)
    buscarRutas()
    const currentYear = new Date().getFullYear()
    for (let y = 2020; y <= 2030; y++) {
        years.value.push(y)
    }
    loadData()
})

function showTable(tabla) {
    visibleTable.value = tabla
}

function selectRuta(ruta) {
    selectedRuta.value = ruta
    form.value.idRuta = ruta.id
    visibleTable.value = null
}

function selectUsuario(user) {
    selectedUsuario.value = user
    form.value.idUser = user.id
    visibleTable.value = null
}


function submit() {
    processing.value = true
    errors.value = {}

    router.post('/nLecturaMovil/sistema/lecturadores', form.value, {
        onSuccess: () => {
            processing.value = false
            // Opcional: limpiar formulario
            // form.value = { idRuta: '', idUser: '', periodo: '' }
            // selectedRuta.value = null
            // selectedUsuario.value = null
            // selectedYear.value = ''
            // selectedMonth.value = ''
        },
        onError: (err) => {
            processing.value = false
            errors.value = err
        },
    })
}
</script>

<style scoped>
.form-input {
    outline: none;
    transition: border-color 0.2s;
}

.form-input:focus {
    border-color: #2563eb;
}
</style>
