@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Crear Nueva Ruta de Instalación</h1>

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
        {{-- Columna del formulario --}}
        <div class="col-md-6">
            <form action="{{ route('instalaciones.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="idZona" class="form-label">Zona</label>
                    <select name="idZona" id="idZona" class="form-select @error('idZona') is-invalid @enderror" required>
                        <option value="">Selecciona una zona</option>
                        @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}" {{ old('idZona') == $zona->id ? 'selected' : '' }}>
                            {{ $zona->NombreZona }}
                        </option>
                        @endforeach
                    </select>
                    @error('idZona')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="idRuta" class="form-label">Ruta</label>
                    <select name="idRuta" id="idRuta" class="form-select @error('idRuta') is-invalid @enderror" required>
                        <option value="">Selecciona una ruta</option>
                        @foreach ($rutas as $ruta)
                        <option value="{{ $ruta->id }}" {{ old('idRuta') == $ruta->id ? 'selected' : '' }}>
                            {{ $ruta->NombreRuta }}
                        </option>
                        @endforeach
                    </select>
                    @error('idRuta')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="idPredio" class="form-label">Predio</label>
                    <select name="idPredio" id="idPredio" class="form-select @error('idPredio') is-invalid @enderror" required>
                        <option value="">Selecciona un predio</option>
                        @foreach ($predios as $predio)
                        <option value="{{ $predio->id }}" {{ old('idPredio') == $predio->id ? 'selected' : '' }}>
                            {{ $predio->nombre ?? 'Predio ' . $predio->id }}
                        </option>
                        @endforeach
                    </select>
                    @error('idPredio')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nInstalacion" class="form-label">Número o Nombre de Instalación</label>
                    <input type="text" name="nInstalacion" id="nInstalacion"
                        class="form-control w-100 @error('nInstalacion') is-invalid @enderror"
                        value="{{ old('nInstalacion') }}" required>
                    @error('nInstalacion')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary">Volver atrás</a>
                    <button type="submit" class="btn btn-primary">Crear Ruta de Instalación</button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <h5>Información Seleccionada</h5>

            <div id="zonaInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Zona</th>
                        <td id="nombreZona"></td>
                    </tr>
                </table>
            </div>
            <div id="rutaInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Ruta</th>
                        <td id="nombreRuta"></td>
                    </tr>
                </table>
            </div>

            <div id="predioInfo" style="display:none;">
                <table class="table table-bordered">
                    <tr>
                        <th>Dirección</th>
                        <td id="direccionPredio"></td>
                    </tr>
                    <tr>
                        <th>Distrito</th>
                        <td id="distritoPredio"></td>
                    </tr>
                    <tr>
                        <th>Área del Predio</th>
                        <td id="areaPredio"></td>
                    </tr>
                    <tr>
                        <th>Número de Pisos</th>
                        <td id="pisosPredio"></td>
                    </tr>
                    <tr>
                        <th>Tipo Edificación</th>
                        <td id="tipoEdificacion"></td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td id="estadoEdificacion"></td>
                    </tr>
                </table>
            </div>


        </div>


    </div>
</div>
<script>
    const rutas = @json($rutas);
    const predios = @json($predios);
    const zonas = @json($zonas);

    document.addEventListener('DOMContentLoaded', function() {
        const rutaSelect = document.getElementById('idRuta');
        const predioSelect = document.getElementById('idPredio');
        const zonaSelect = document.getElementById('idZona');

        const rutaInfo = document.getElementById('rutaInfo');
        const predioInfo = document.getElementById('predioInfo');
        const zonaInfo = document.getElementById('zonaInfo');

        rutaSelect.addEventListener('change', function() {
            const rutaId = this.value;
            const ruta = rutas.find(r => r.id == rutaId);

            if (ruta) {
                document.getElementById('nombreRuta').textContent = ruta.NombreRuta || '';
                rutaInfo.style.display = 'block';
            }
        });

        predioSelect.addEventListener('change', function() {
            const predioId = this.value;
            const predio = predios.find(p => p.id == predioId);

            if (predio) {
                document.getElementById('direccionPredio').textContent = predio.direccion || '';
                document.getElementById('distritoPredio').textContent = predio.distrito || '';
                document.getElementById('areaPredio').textContent = predio.AreaPredio || '';
                document.getElementById('pisosPredio').textContent = predio.NroPisos || '';
                document.getElementById('tipoEdificacion').textContent = predio.TipoEdificacion || '';
                document.getElementById('estadoEdificacion').textContent = predio.EstadoEdificacion || '';
                predioInfo.style.display = 'block';
            }
        });

        zonaSelect.addEventListener('change', function() {
            const zonaId = this.value;
            const zona = zonas.find(z => z.id == zonaId);

            if (zona) {
                document.getElementById('nombreZona').textContent = zona.NombreZona || '';
                zonaInfo.style.display = 'block';
            }
        });
    });
</script>


@endsection