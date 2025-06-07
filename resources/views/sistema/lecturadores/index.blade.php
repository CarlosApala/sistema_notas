@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Lecturadores  @if(request('deleted'))
        eliminados
        @else

        @endif</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('lecturadores.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Buscar por periodo o usuario..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <a href="{{ route('lecturadores.create') }}" class="btn btn-success">Asingar Ruta</a>
        @if(request('deleted'))
        <a href="{{ route('lecturadores.index') }}" class="btn btn-secondary">Ver Activos</a>
        @else
        <a href="{{ route('lecturadores.index', ['deleted' => true]) }}" class="btn btn-secondary">Ver Eliminados</a>
        @endif
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Ruta</th>
                <th>ID Usuario</th>
                <th>Periodo</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asignaciones as $asignacion)
            <tr>
                <td>{{ $asignacion->id }}</td>
                <td>{{ $asignacion->idRuta }}</td>
                <td>{{ $asignacion->idUser }}</td>
                <td>{{ $asignacion->periodo ?? '-' }}</td>
                <td>{{ $asignacion->created_at }}</td>
                <td>{{ $asignacion->updated_at }}</td>
                <td>
                    @if(request('deleted'))
                    {{-- Botón Restaurar --}}
                    <form action="{{ route('lecturadores.restore', $asignacion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-success btn-sm" onclick="return confirm('¿Restaurar esta asignación?')">Restaurar</button>
                    </form>
                    @else
                    {{-- Botón Ver --}}
                    <a href="{{ route('lecturadores.show', $asignacion->id) }}" class="btn btn-info btn-sm" title="Ver">
                        <i class="bi bi-eye"></i> Ver
                    </a>

                    {{-- Botón Editar --}}
                    <a href="{{ route('lecturadores.edit', $asignacion->id) }}" class="btn btn-warning btn-sm" title="Editar">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>

                    {{-- Botón Eliminar --}}
                    <form action="{{ route('lecturadores.destroy', $asignacion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</button>
                    </form>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No se encontraron asignaciones.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $asignaciones->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection