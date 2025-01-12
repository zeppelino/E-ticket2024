<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a {{ $nombreEvento }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <h1 class="event-name">Inscripción a {{ $nombreEvento }}</h1>
            </div>
            <div class="ticket-body">
                <h3>Hola {{ $nombreUsuario }}!</h3>
                <p class="justified-paragraph">Te has inscrito exitosamente en la <strong>lista de espera</strong> para
                    el evento <strong>{{ $nombreEvento }}</strong>.</p>
                <p class="justified-paragraph">Te enviaremos un correo electrónico cuando sea tu turno para comprar la
                    entrada. Recuerda que una vez recibas la notificación, tendrás un plazo de <strong>10
                        minutos</strong> para realizar la compra de tu entrada. Si no lo haces en ese tiempo, se
                    ofrecerá tu lugar a otra persona en la lista de espera.</p>
                <div class="text-center mt-4">
                    <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}" class="btn-custom">Ver
                        Detalles del Evento</a>
                </div>
                <!-- Información adicional -->
                <p class="text-muted mt-4">
                    Gracias por tu interés en participar en el evento. Estamos emocionados de tenerte en nuestra lista
                    de espera. ¡Mantente atento a tu correo!
                </p>
            </div>
            <footer class="text-center mt-4">
                <p class="text-muted">© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
            </footer>
        </div>    
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
