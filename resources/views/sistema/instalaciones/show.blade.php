@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Detalle de Ruta de Instalación</h1>
    <a href="{{ route('instalaciones.edit', $ruta->id) }}" class="btn btn-primary mt-3">Editar</a>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Código Completo: {{ $ruta->codigo_completo ?? 'N/D' }}</h5>

            <p><strong>Zona:</strong> {{ $ruta->zona->nombre ?? 'N/D' }}</p>
            <p><strong>Ruta:</strong> {{ $ruta->ruta->nombre ?? 'N/D' }}</p>
            <p><strong>Predio:</strong> {{ $ruta->predio->id ?? 'N/D' }}</p>
            <p><strong>Instalación:</strong> {{ $ruta->nInstalacion ?? 'N/D' }}</p>

            <p><strong>Fecha de creación:</strong> {{ $ruta->created_at ? $ruta->created_at->format('d/m/Y H:i:s') : 'N/D' }}</p>
            <p><strong>Fecha de actualización:</strong> {{ $ruta->updated_at ? $ruta->updated_at->format('d/m/Y H:i:s') : 'N/D' }}</p>
        </div>
    </div>

    <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>

</div>
@endsection
