@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Crear Nuevo Usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input type="text" name="username" id="username"
                   class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username') }}" required>
            @error('username')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required>
            @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" required>
        </div>

        <hr>
        <h4>Roles</h4>
        <div class="mb-3">
            @foreach ($roles as $role)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="roles[]"
                        value="{{ $role->name }}"
                        id="role_{{ $role->id }}"
                        {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ ucfirst($role->name) }}
                    </label>
                </div>
            @endforeach
        </div>

        <h4>Permisos Directos</h4>
        <div class="mb-3">
            @foreach ($permisos as $permiso)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="permisos[]"
                        value="{{ $permiso->name }}"
                        id="permiso_{{ $permiso->id }}"
                        {{ in_array($permiso->name, old('permisos', [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="permiso_{{ $permiso->id }}">
                        {{ $permiso->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
@endsection
