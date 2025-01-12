@extends('layouts.header')

@section('content')
    <div class="container mt-5 text-center">

        @if (isset($numeroTransaccion))
            <h1>¡Compra Exitosa!</h1>
            <p>Gracias por tu compra. Tu número de transacción es: <strong>{{ $numeroTransaccion }}</strong></p>
            <p>Evento: <strong>{{ $evento->nombreEvento }}</strong></p>
            <p>Tipo de Entrada: <strong>{{ $categoriaTicket->nombreCatTicket }}</strong></p>
            <p>Descripción: <strong>{{ $tipoTicket->descripcionTipoTicket }}</strong></p>
            <p>Usuario: <strong>{{ $user->name }}</strong></p>
            <div class="d-grid gap-2 mt-4">
                <!-- Temporizador -->
                <div class="text-center mb-4">
                    <br><br><br>
                    <p>Se redirigira a la pagina principal en:</p>
                    <p id="timer" class="display-4">00:00:15</p>
                </div>
            </div>
        @else
            <h1>Compra Fallida...</h1>
            <br>
            <p><strong>Lo sentimos, la compra no pudo completarse. Por favor, vuelva a seleccionar su tipo de ticket e
                    inténtelo nuevamente.</strong></p>
            <div class="d-grid gap-2 mt-4">
                <br><br>
                <a href="{{ $enlaceCompra }}" class="btn btn-success btn-lg">Volver a Intentar</a>
                <a href="{{ route('welcome') }}" class="btn btn-warning btn-lg">Ir a la pagina Principal</a>
            </div>
        @endif
    </div>

    <!-- Temporizador JavaScript (Se ejecuta solo si la compra fue exitosa) -->
    <?php if (isset($numeroTransaccion)) : ?>
    <script>
        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = 0;
                    // Redirigir a la página principal
                    window.location.href = "{{ route('welcome') }}";
                }
            }, 1000);
        }

        window.onload = function() {
            var timeRemaining = 15; // 15 segundos
            var display = document.getElementById('timer');
            startTimer(timeRemaining, display);
        };
    </script>
    <?php endif; ?>
@endsection
