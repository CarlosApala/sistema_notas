@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Detalle de Asignación de Ruta</h1>

    <a href="{{ route('lecturadores.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>

    <div class="card">
        <div class="card-body">
            <h5>ID: {{ $asignacion->id }}</h5>
            <p><strong>ID Ruta:</strong> {{ $asignacion->idRuta }}</p>
            <p><strong>ID Usuario:</strong> {{ $asignacion->idUser }}</p>
            <p><strong>Periodo:</strong> {{ $asignacion->periodo ?? '-' }}</p>
            <p><strong>Creado en:</strong> {{ $asignacion->created_at }}</p>
            <p><strong>Actualizado en:</strong> {{ $asignacion->updated_at }}</p>

            {{-- Mostrar datos relacionados --}}
            <h5>Detalles de la ruta</h5>
            @if($asignacion->rutaInstalacion)
                <p><strong>Nombre Instalación:</strong> {{ $asignacion->rutaInstalacion->nInstalacion }}</p>
                {{-- Más detalles de rutaInstalacion según tengas --}}
            @endif

            <h5>Datos del usuario</h5>
            @if($asignacion->usuario)
                <p><strong>Nombre:</strong> {{ $asignacion->usuario->name ?? 'Sin nombre' }}</p>
                <p><strong>Email:</strong> {{ $asignacion->usuario->email ?? 'Sin email' }}</p>
                {{-- Más detalles del usuario si quieres --}}
            @endif
        </div>
    </div>
</div>
@endsection
