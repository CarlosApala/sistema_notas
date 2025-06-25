<template>
  <div class="zonas-rutas-wrapper">
    <div class="row h-100">
      <!-- Columna Izquierda: botones para elegir vista -->
      <div class="col-md-4 h-100">
        <div class="card shadow-sm h-50 d-flex flex-column">
          <div class="card-header">
            <h5 class="mb-0">Opciones</h5>
          </div>
          <div class="card-body d-grid gap-2">
            <button class="btn btn-outline-dark" @click="vista = 'zonas'">Zonas</button>
            <button class="btn btn-outline-dark" @click="vista = 'rutas'">Rutas</button>
            <button class="btn btn-outline-dark" @click="vista = 'asignaciones'">Asignaciones</button>
          </div>
        </div>
      </div>

      <!-- Columna Derecha: tabla y paginación -->
      <div class="col-md-8 h-100">
        <div class="card shadow-sm h-100 d-flex flex-column">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ tituloVista }}</h5>
            <button class="btn btn-success btn-sm" @click="abrirModalRegistro(vista)">Registrar</button>
          </div>
          <div class="card-body overflow-auto">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th v-if="vista === 'zonas' || vista === 'asignaciones'">Zona</th>
                  <th v-if="vista === 'rutas' || vista === 'asignaciones'">Ruta</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="vista === 'zonas'" v-for="(zona, index) in listaActiva" :key="zona.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ zona.NombreZona }}</td>
                  <td class="text-nowrap">
                    <button class="btn btn-warning btn-sm me-1" @click="editar(zona)">Editar</button>

                    <button class="btn btn-danger btn-sm" @click="eliminar(zona.id)">Eliminar</button>
                  </td>
                </tr>

                <tr v-if="vista === 'rutas'" v-for="(ruta, index) in listaActiva" :key="ruta.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ ruta.NombreRuta }}</td>
                  <td class="text-nowrap">
                    <button class="btn btn-warning btn-sm me-1" @click="editar(ruta)">Editar</button>

                    <button class="btn btn-danger btn-sm" @click="eliminar(ruta.id)">Eliminar</button>
                  </td>
                </tr>

                <tr v-if="vista === 'asignaciones'" v-for="(item, index) in asignaciones" :key="item.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.zona?.NombreZona || '—' }}</td>
                  <td>{{ item.ruta?.NombreRuta || '—' }}</td>
                  <td class="text-nowrap">
                    <button class="btn btn-danger btn-sm" @click="eliminar(item.id)">Eliminar</button>
                  </td>
                </tr>

                <tr v-if="listaActiva.length === 0">
                  <td :colspan="vista === 'asignaciones' ? 4 : 3" class="text-center">No hay registros para mostrar</td>
                </tr>
              </tbody>
            </table>

            <!-- PAGINACIÓN para Zonas y Rutas -->
            <div class="mt-3" v-if="vista === 'zonas' || vista === 'rutas'">
              <nav>
                <ul class="pagination justify-content-center">
                  <li
                    v-for="(link, index) in (vista === 'zonas' ? zonas.links : rutas.links)"
                    :key="index"
                    :class="['page-item', { active: link.active, disabled: !link.url }]"
                  >
                    <a
                      href="#"
                      class="page-link"
                      v-if="link.url"
                      @click.prevent="cambiarPagina(link)"
                      v-html="link.label"
                    ></a>
                    <span class="page-link" v-else v-html="link.label"></span>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted,watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import App from '@/Layouts/AppLayout.vue'

defineOptions({ layout: App })

const zonas = ref({ data: [], links: [] })
const rutas = ref({ data: [], links: [] })
const asignaciones = ref([
    { id: 1, zona: { NombreZona: 'Zona A' }, ruta: { NombreRuta: 'Ruta 1' } },
    { id: 2, zona: { NombreZona: 'Zona B' }, ruta: { NombreRuta: 'Ruta 2' } },
])
const vista = ref('zonas')


watch(vista, () => {
  cargarDatosVistaActiva()
})

const tituloVista = computed(() => {
    if (vista.value === 'zonas') return 'Lista de Zonas'
    if (vista.value === 'rutas') return 'Lista de Rutas'
    return 'Asignaciones Zonas – Rutas'
})

const listaActiva = computed(() => {
    if (vista.value === 'zonas') return zonas.value.data ?? []
    if (vista.value === 'rutas') return rutas.value.data ?? []
    return asignaciones.value
})

// 🔁 CARGA DE DATOS ASÍNCRONOS
async function loadZonas(url = '/sistema/zonas') {
  try {
    const res = await fetch(url, {
      credentials: 'same-origin' // ¡IMPORTANTE! envía cookies para mantener sesión
    })
    if (!res.ok) throw new Error('Error al cargar zonas')
    zonas.value = await res.json()
  } catch (err) {
    console.error('Error cargando zonas:', err)
  }
}

async function loadRutas(url = '/sistema/rutas') {
  try {
    const res = await fetch(url, {
      credentials: 'same-origin' // ¡IMPORTANTE!
    })
    if (!res.ok) throw new Error('Error al cargar rutas')
    rutas.value = await res.json()
  } catch (err) {
    console.error('Error cargando rutas:', err)
  }
}

function cargarDatosVistaActiva() {
    if (vista.value === 'zonas') loadZonas()
    if (vista.value === 'rutas') loadRutas()
}

// 🔄 Al cambiar de vista
watch(vista, () => {
    cargarDatosVistaActiva()
})

// 🚀 Primera carga
onMounted(() => {
    cargarDatosVistaActiva()
})

function cambiarPagina(link) {
  if (!link.url) return

  const relativeUrl = new URL(link.url, window.location.origin).pathname + new URL(link.url).search

  if (vista.value === 'zonas') loadZonas(relativeUrl)
  if (vista.value === 'rutas') loadRutas(relativeUrl)
}



async function abrirModalRegistro(tipo) {
    let inputLabel = '', inputPlaceholder = '', url = '', fieldName = ''

    switch (tipo) {
        case 'rutas':
            inputLabel = 'Nombre de la Ruta'
            inputPlaceholder = 'Ingrese el nombre de la ruta'
            url = '/sistema/rutas'
            fieldName = 'NombreRuta'
            break
        case 'zonas':
            inputLabel = 'Nombre de la Zona'
            inputPlaceholder = 'Ingrese el nombre de la zona'
            url = '/sistema/zonas'
            fieldName = 'NombreZona'
            break
        case 'asignacion':
            const { value: formValues } = await Swal.fire({
                title: 'Registrar Asignación',
                html:
                    `<select id="swal-zona" class="swal2-select" style="width: 100%; padding: .5rem; margin-bottom: 1rem;">
                        <option value="" disabled selected>Seleccione Zona</option>
                        ${zonas.value.data.map(z => `<option value="${z.id}">${z.NombreZona}</option>`).join('')}
                    </select>` +
                    `<select id="swal-ruta" class="swal2-select" style="width: 100%; padding: .5rem;">
                        <option value="" disabled selected>Seleccione Ruta</option>
                        ${rutas.value.data.map(r => `<option value="${r.id}">${r.NombreRuta}</option>`).join('')}
                    </select>`,
                focusConfirm: false,
                preConfirm: () => {
                    const zonaId = document.getElementById('swal-zona').value
                    const rutaId = document.getElementById('swal-ruta').value
                    if (!zonaId || !rutaId) {
                        Swal.showValidationMessage('Por favor seleccione Zona y Ruta')
                        return null
                    }
                    return { zona_id: zonaId, ruta_id: rutaId }
                }
            })

            if (formValues) {
                const asignacionForm = useForm(formValues)
                asignacionForm.post('/sistema/asignaciones', {
                    onSuccess: () => {
                        Swal.fire('¡Registrado!', 'Asignación registrada.', 'success')
                        asignacionForm.reset()
                    },
                    onError: () => {
                        Swal.fire('Error', 'No se pudo registrar.', 'error')
                    }
                })
            }
            return
    }

    const { value: nombre } = await Swal.fire({
        title: `Registrar ${tipo}`,
        input: 'text',
        inputLabel: inputLabel,
        inputPlaceholder: inputPlaceholder,
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) return `${inputLabel} es obligatorio`
        },
    })

    if (nombre) {
        const data = {}
        data[fieldName] = nombre

        const form = useForm(data)
        form.post(url, {
            onSuccess: () => {
                Swal.fire('¡Registrado!', `${tipo} registrado.`, 'success')
                form.reset()
                cargarDatosVistaActiva()
            },
            onError: () => {
                Swal.fire('Error', `No se pudo registrar ${tipo}.`, 'error')
            }
        })
    }
}

async function editar(item) {
  const esZona = vista.value === 'zonas'
  const esRuta = vista.value === 'rutas'

  const label = esZona ? 'Nombre de la Zona' : 'Nombre de la Ruta'
  const fieldName = esZona ? 'NombreZona' : 'NombreRuta'
  const url = esZona ? `/sistema/zonas/${item.id}` : `/sistema/rutas/${item.id}`
  const valorActual = item[fieldName]

  const { value: nuevoValor } = await Swal.fire({
    title: 'Editar registro',
    input: 'text',
    inputLabel: label,
    inputValue: valorActual,
    showCancelButton: true,
    confirmButtonText: 'Actualizar',
    cancelButtonText: 'Cancelar',
    inputValidator: (value) => {
      if (!value) {
        return `${label} es obligatorio`
      }
    }
  })

  if (!nuevoValor) return

  try {
    const res = await fetch(url, {
      method: 'PUT', // o PATCH según tu controlador
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      },
      body: JSON.stringify({ [fieldName]: nuevoValor })
    })

    if (!res.ok) throw new Error('Error al actualizar')

    await Swal.fire('¡Actualizado!', 'El registro fue actualizado.', 'success')
    cargarDatosVistaActiva()

  } catch (error) {
    console.error(error)
    Swal.fire('Error', 'No se pudo actualizar el registro.', 'error')
  }
}


async function eliminar(id) {
  const result = await Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  });
  console.log("holsadf asdfasljdfl")
  if (!result.isConfirmed) return;
  console.log("asd sadlfasdf adsf,asdflasdlfjlasdjfasn")

  try {
    const urlBase = vista.value === 'zonas' ? '/sistema/zonas' : '/sistema/rutas';

    const res = await fetch(`${urlBase}/${id}`, {
      method: 'DELETE',
      credentials: 'same-origin',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    });
    console.log("cual es el valor")
    console.log(res)
    if (!res.ok) throw new Error('Error al eliminar');

    await Swal.fire('¡Eliminado!', 'El registro fue eliminado correctamente.', 'success');

    cargarDatosVistaActiva(); // Recargar la lista

  } catch (error) {
    console.error(error);
    Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
  }
}

</script>
<style scoped>
.zonas-rutas-wrapper {
  height: 90vh; /* altura total de la ventana */
  padding: 1rem;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.row.h-100 {
  height: 100%; /* que ocupe todo el contenedor padre */
  display: flex;
}

.col-md-4.h-100,
.col-md-8.h-100 {
  height: 100%; /* que ocupe toda la altura disponible */
}

.card.h-100 {
  height: 100%; /* para que el card ocupe toda la altura de la columna */
  display: flex;
  flex-direction: column;
}

.card-body.overflow-auto {
  flex-grow: 1; /* que ocupe el espacio restante */
  overflow-y: auto; /* scroll solo vertical */
}
</style>
