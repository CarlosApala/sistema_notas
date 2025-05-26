@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Lista de Usuarios</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">Crear Nuevo Usuario</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
