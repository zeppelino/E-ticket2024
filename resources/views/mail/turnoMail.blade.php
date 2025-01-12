<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Turno</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .ticket {
            max-width: 600px;
            margin: 10% auto;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .ticket-body {
            padding: 20px;
        }

        .event-name {
            font-size: 1.5rem;
            margin-bottom: 0;
        }

        .logo-space {
            padding: 20px;
            text-align: center;
            background-color: #000;
            color: #fff;
        }

        .logo-space img {
            max-height: 80px;
            width: auto;
            margin-bottom: 10px;
        }

        .justified-paragraph {
            text-align: justify;
        }
        .btn-custom {
            background-color: #2850a7;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block; /* Asegura que se pueda centrar */
        }
        .btn-custom:hover {
            background-color: #212388;
        }
        .button-container {
            text-align: center; /* Centrar el botón */
            margin: 20px 0; /* Espaciado alrededor del botón */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="ticket">
            <div class="logo-space">
                <!-- ACA VA EL LOGO DE LA EMPRESA -->
                <img src="https://i.ibb.co/nB1BLnf/logo-con-nombre.jpg"  alt="Logo de la Empresa4" class="logo">
                <h1 class="event-name">¡Es tu turno!</h1>
            </div>
            <div class="ticket-body">
                <h3>Hola {{ $nombreCliente }}!</h3>
                <p class="justified-paragraph">Nos complace informarte que ha llegado tu turno para adquirir tu entrada
                    al evento <strong>{{ $nombreEvento }}</p>
                <p class="justified-paragraph">Aquí tienes los detalles:</p>
                <ul>
                    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fechaEvento)->format('d/m/Y H:i A') }}</li>
                    <li><strong>Lugar:</strong> {{ $lugarEvento }}</li>
                </ul>
                <div class="text-center mt-4">

                    <a href="{{ $enlaceCompra }}" class="btn-custom" target="_blank"
                        rel="noopener noreferrer">Compra tu entrada aquí</a>
                </div>
            </div>
            <footer class="text-center mt-4">
                <p class="text-muted">© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Tanda</title>
</head>
<body>
    <h1>Hola, {{ $nombreCliente }}!</h1>
    <p>Te recordamos que estás inscripto en el evento <strong>{{ $nombreEvento }}</strong>.</p>
    
    <p><strong>Fecha del evento:</strong> {{ \Carbon\Carbon::parse($fechaEvento)->format('d/m/Y') }}</p>
    <p><strong>Lugar:</strong> {{ $lugarEvento }}</p>

    <p>Puedes adquirir tu entrada en el siguiente enlace:</p>
    <a href="{{ $enlaceCompra }}">Comprar entrada</a>

    <p><em>Este enlace expirará en {{ $tiempoVencimiento }} minuto(s).</em></p>

    <p>¡Nos vemos pronto!</p>
</body>
</html> --}}
