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
        </div>
    </div>

    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
