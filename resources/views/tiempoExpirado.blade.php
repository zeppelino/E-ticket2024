@extends('layouts.header')

@section('content')

<style>
    .expired-message {
        color: #dc3545; /* Color rojo para el mensaje */
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        margin-top: 50px;
    }

    .container {
        text-align: center; /* Centrar contenido */
    }

    .btn-primary {
        margin-top: 20px;
    }
</style>

<div class="container mt-5">
    <h1 class="expired-message">El tiempo de compra ha expirado</h1>
    <p class="lead">Lamentablemente, el tiempo para adquirir tu entrada ha finalizado.</p>
    
    <p>Te invitamos a inscribirte nuevamente o revisar otros eventos disponibles.</p>

    <!-- Botón para regresar o redirigir -->
    <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg">Ver otros eventos</a>
</div>

@endsection