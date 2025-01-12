<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$nombreEvento}}: Suspendido</title>
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
            <!-- Título del email -->
            <div class="logo-space">
            <!-- ACA VA EL LOGO DE LA EMPRESA -->
                <img src="https://i.ibb.co/nB1BLnf/logo-con-nombre.jpg"  alt="Logo de la Empresa4" class="logo">
                <h1 class="event-name">{{ $nombreEvento }}: SUSPENDIDO</h1>
            </div>
            <div class="ticket-body">
                <!-- Cuerpo del mensaje -->
                <h3>Estimado/a {{ $nombreUsuario }},</h3>

                <p class="justified-paragraph">El evento <strong>{{ $nombreEvento }}</strong> programado para el <strong>{{ $fechaRealizacion }} hs</strong> ha sido <span class="text-warning">suspendido temporalmente</span>.</p>

                <p class="justified-paragraph">Nos pondremos en contacto contigo en cuanto tengamos una nueva fecha programada para el evento. Si ya habías adquirido una entrada, se te notificará sobre los siguientes pasos.</p>

                <!-- Información adicional -->
                <p class="text-muted justified-paragraph">
                Agradecemos tu paciencia y comprensión durante este proceso. Estamos trabajando para reprogramar el evento lo antes posible.
                </p>

                <!-- Botón de regreso -->
                <div class="text-center mt-4">
                    <a href="{{ route('welcome') }}" class="btn-custom">Ir a la página principal</a>
                </div>
            </div>
            <!-- Footer -->
            <footer class="text-center">
                <p class="text-muted">© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>