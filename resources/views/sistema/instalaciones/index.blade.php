@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Lista de Rutas de Instalaciones</h1>

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
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <a href="{{ route('instalaciones.create') }}" class="btn btn-success">Crear Nueva Ruta</a>
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
                    <a href="{{ route('instalaciones.show', $ruta->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('instalaciones.edit', $ruta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('instalaciones.destroy', $ruta->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta instalación?')">Eliminar</button>
                    </form>
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
