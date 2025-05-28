@extends('home.index')

@section('contenido')
<div class="container">
    <h1>Detalle del Usuario</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Usuario:</strong> {{ $user->username }}</p>
            <p class="card-text"><strong>Verificado:</strong>
                {{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y H:i:s') : 'No verificado' }}
            </p>
            <p class="card-text"><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
            <p class="card-text"><strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>

            <hr>

            <h4>Roles asignados:</h4>
            @if($user->roles->isEmpty())
                <p>Este usuario no tiene roles asignados.</p>
            @else
                <ul>
                    @foreach($user->roles as $rol)
                        <li>{{ $rol->name }}</li>
                    @endforeach
                </ul>
            @endif

            <h4>Permisos del usuario (directos e indirectos):</h4>
            @if($permisosUsuario->isEmpty())
                <p>Este usuario no tiene permisos asignados.</p>
            @else
                <ul>
                    @foreach($permisosUsuario as $permiso)
                        <li>{{ $permiso }}</li>
                    @endforeach
                </ul>
            @endif

            <h4>Permisos agrupados por rol:</h4>
            @if(empty($permisosPorRol))
                <p>No hay permisos asignados por rol.</p>
            @else
                @foreach($permisosPorRol as $rol => $permisos)
                    <strong>Rol: {{ $rol }}</strong>
                    <ul>
                        @foreach($permisos as $permiso)
                            <li>{{ $permiso }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endif

        </div>
    </div>

    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
