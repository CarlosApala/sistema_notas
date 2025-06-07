@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Instalaciones @if(request('deleted'))
        eliminados
        @else

        @endif</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('instalaciones.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <a href="{{ route('instalaciones.create') }}" class="btn btn-success">Crear Nueva Ruta</a>
        @if(request('deleted'))
        <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary">Ver Activas</a>
        @else
        <a href="{{ route('instalaciones.index', ['deleted' => true]) }}" class="btn btn-secondary">Ver Eliminadas</a>
        @endif
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Zona</th>
                <th>Ruta</th>
                <th>Predio</th>
                <th>Instalación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rutas as $ruta)
            <tr>
                <td>{{ $ruta->codigo_completo }}</td>
                <td>{{ $ruta->zona->nombre ?? '-' }}</td>
                <td>{{ $ruta->ruta->nombre ?? '-' }}</td>
                <td>{{ $ruta->predio->nombre ?? '-' }}</td>
                <td>{{ $ruta->nInstalacion }}</td>
                <td>
                    @if(request('deleted'))
                    {{-- Mostramos la fecha de eliminación y un botón de restaurar --}}
                    <div class="text-muted">
                        Eliminado el {{ $ruta->deleted_at->format('d/m/Y H:i') }}
                    </div>
                    <form action="{{ route('instalaciones.restore', $ruta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-success btn-sm" onclick="return confirm('¿Restaurar esta instalación?')">Restaurar</button>
                    </form>
                    @else
                    {{-- Acciones normales si NO está eliminado --}}
                    <a href="{{ route('instalaciones.show', $ruta->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('instalaciones.edit', $ruta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('instalaciones.destroy', $ruta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta instalación?')">Eliminar</button>
                    </form>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No se encontraron rutas de instalaciones.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $rutas->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection