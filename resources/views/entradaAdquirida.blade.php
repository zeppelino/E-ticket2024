@extends('layouts.header')

@section('content')

<style>
    .message {
        color: #28a745; /* Verde para mensaje de éxito */
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        margin-top: 50px;
    }

    .container {
        text-align: center;
    }

    .btn {
        margin: 10px; /* Espacio entre los botones */
    }

    .lead {
        margin-top: 20px;
    }
</style>

<div class="container mt-5">
    <h1 class="message">¡Ya adquiriste tu entrada para {{$evento -> nombreEvento}}!</h1>
    <p class="lead">{{$user -> name}}: Gracias por completar tu compra. Si deseas, puedes ver tus entradas o inscribirte nuevamente a este evento.</p>

    <!-- Botones de acción -->

    <a href="{{ route('verMisEntradas') }}" class="btn btn-success btn-lg">Ver mis entradas</a>
    <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}" class="btn btn-warning btn-lg">Inscribirse nuevamente</a>
    <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg">Ver otros eventos</a>

</div>

@endsection
