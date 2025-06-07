@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Asignar Ruta a Lecturador</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        {{-- Columna formulario --}}
        <div class="col-md-6">
            <form action="{{ route('lecturadores.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="idRuta" class="form-label">Ruta de Instalación</label>
                    <select name="idRuta" id="idRuta" class="form-select @error('idRuta') is-invalid @enderror" required>
                        <option value="">Selecciona una ruta</option>
                        @foreach ($rutas as $ruta)
                        <option value="{{ $ruta->id }}" {{ old('idRuta') == $ruta->id ? 'selected' : '' }}>
                            {{ $ruta->ruta->NombreRuta ?? 'Ruta #' . $ruta->id }} - {{ $ruta->nInstalacion }}
                        </option>
                        @endforeach
                    </select>
                    @error('idRuta')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="idUser" class="form-label">Lecturador</label>
                    <select name="idUser" id="idUser" class="form-select @error('idUser') is-invalid @enderror" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('idUser') == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->name }} ({{ $usuario->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('idUser')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="periodo" class="form-label">Período</label>
                    <input type="text" name="periodo" id="periodo"
                        class="form-control @error('periodo') is-invalid @enderror"
                        placeholder=""
                        value="{{ old('periodo') }}" required>
                    @error('periodo')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('lecturadores.index') }}" class="btn btn-secondary">Volver atrás</a>
                    <button type="submit" class="btn btn-primary">Asignar Ruta</button>
                </div>
            </form>
        </div>

        {{-- Columna información seleccionada --}}
        <div class="col-md-6">
            <h5>Información Seleccionada</h5>

            <div id="rutaInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Nombre Ruta</th>
                        <td id="nombreRuta"></td>
                    </tr>
                    <tr>
                        <th>Número Instalación</th>
                        <td id="numeroInstalacion"></td>
                    </tr>
                </table>
            </div>

            <div id="usuarioInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Nombre Lecturador</th>
                        <td id="nombreUsuario"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="emailUsuario"></td>
                    </tr>
                </table>
            </div>

            <div id="periodoInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Período</th>
                        <td id="periodoSeleccionado"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Datos del backend en JSON
    const rutas = @json($rutas);
    const usuarios = @json($usuarios);

    document.addEventListener('DOMContentLoaded', function() {
        const rutaSelect = document.getElementById('idRuta');
        const usuarioSelect = document.getElementById('idUser');
        const periodoInput = document.getElementById('periodo');

        const rutaInfo = document.getElementById('rutaInfo');
        const usuarioInfo = document.getElementById('usuarioInfo');
        const periodoInfo = document.getElementById('periodoInfo');

        // Mostrar info de ruta al cambiar selección
        rutaSelect.addEventListener('change', function() {
            const rutaId = this.value;
            const ruta = rutas.find(r => r.id == rutaId);

            if (ruta) {
                document.getElementById('nombreRuta').textContent = ruta.ruta?.NombreRuta || 'N/A';
                document.getElementById('numeroInstalacion').textContent = ruta.nInstalacion || 'N/A';
                rutaInfo.style.display = 'block';
            } else {
                rutaInfo.style.display = 'none';
            }
        });

        // Mostrar info de usuario al cambiar selección
        usuarioSelect.addEventListener('change', function() {
            const usuarioId = this.value;
            const usuario = usuarios.find(u => u.id == usuarioId);

            if (usuario) {
                document.getElementById('nombreUsuario').textContent = usuario.name || 'N/A';
                document.getElementById('emailUsuario').textContent = usuario.email || 'N/A';
                usuarioInfo.style.display = 'block';
            } else {
                usuarioInfo.style.display = 'none';
            }
        });

        // Mostrar período en tiempo real al escribir
        periodoInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                document.getElementById('periodoSeleccionado').textContent = this.value;
                periodoInfo.style.display = 'block';
            } else {
                periodoInfo.style.display = 'none';
            }
        });

        // Si hay valores antiguos para mostrar al cargar la página (como en edición)
        if (rutaSelect.value) {
            rutaSelect.dispatchEvent(new Event('change'));
        }
        if (usuarioSelect.value) {
            usuarioSelect.dispatchEvent(new Event('change'));
        }
        if (periodoInput.value.trim() !== '') {
            periodoInput.dispatchEvent(new Event('input'));
        }
    });


    // para dar valor al input
    document.addEventListener('DOMContentLoaded', () => {
        const inputPeriodo = document.getElementById('periodo');

        // Obtener mes y año actual
        const now = new Date();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Mes con dos dígitos
        const year = String(now.getFullYear()).slice(-2); // Últimos dos dígitos del año

        const defaultValue = `${month}/${year}`;

        // Solo asignar value si no hay valor previo (por ejemplo, old())
        if (!inputPeriodo.value) {
            inputPeriodo.value = defaultValue;
        }

        // Asignar placeholder también
        inputPeriodo.placeholder = defaultValue;
    });
</script>

@endsection