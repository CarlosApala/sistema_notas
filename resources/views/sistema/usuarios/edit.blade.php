@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Editar Usuario</h1>

<form method="POST" action="{{ route('usuarios.update', $usuario) }}">

        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="usuarioname">Nombre de Usuario</label>
            <input type="text" name="username" value="{{ old('username', $usuario->username) }}" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="password">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
