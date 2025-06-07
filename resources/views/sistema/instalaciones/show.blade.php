@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Detalle de Ruta de Instalación</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Código Completo</h5>
                    <p>{{ $ruta->codigo_completo ?? 'N/D' }}</p>

                    <h5 class="card-title">Instalación</h5>
                    <p>{{ $ruta->nInstalacion ?? 'N/D' }}</p>

                    <p><strong>Fecha de creación:</strong> {{ $ruta->created_at ? $ruta->created_at->format('d/m/Y H:i:s') : 'N/D' }}</p>
                    <p><strong>Fecha de actualización:</strong> {{ $ruta->updated_at ? $ruta->updated_at->format('d/m/Y H:i:s') : 'N/D' }}</p>
                </div>
            </div>

            <a href="{{ route('instalaciones.edit', $ruta->id) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary ms-2">Volver a la lista</a>
        </div>

        <div class="col-md-6">
            <h5>Información Relacionada</h5>

            {{-- Zona --}}
            <div class="mb-3">
                <table class="table table-bordered">
                    <tr><th>Zona</th><td>{{ $ruta->zona->NombreZona ?? 'N/D' }}</td></tr>
                </table>
            </div>

            {{-- Ruta --}}
            <div class="mb-3">
                <table class="table table-bordered">
                    <tr><th>Ruta</th><td>{{ $ruta->ruta->NombreRuta ?? 'N/D' }}</td></tr>
                </table>
            </div>

            {{-- Predio --}}
            <div class="mb-3">
                <table class="table table-bordered">
                    <tr><th>ID Predio</th><td>{{ $ruta->predio->id ?? 'N/D' }}</td></tr>
                    <tr><th>Dirección</th><td>{{ $ruta->predio->direccion ?? 'N/D' }}</td></tr>
                    <tr><th>Distrito</th><td>{{ $ruta->predio->distrito ?? 'N/D' }}</td></tr>
                    <tr><th>Área del Predio</th><td>{{ $ruta->predio->AreaPredio ?? 'N/D' }}</td></tr>
                    <tr><th>Número de Pisos</th><td>{{ $ruta->predio->NroPisos ?? 'N/D' }}</td></tr>
                    <tr><th>Tipo Edificación</th><td>{{ $ruta->predio->TipoEdificacion ?? 'N/D' }}</td></tr>
                    <tr><th>Estado</th><td>{{ $ruta->predio->EstadoEdificacion ?? 'N/D' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
