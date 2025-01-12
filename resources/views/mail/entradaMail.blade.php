<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada para Bubble Show</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .ticket {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .ticket-body {
            padding: 20px;
        }
        .qr-code {
            width: 100px;
            height: 100px;
            background-color: #f8f9fa;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
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
        .event-name {
            font-size: 1.5rem;
            margin-bottom: 0;
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
            {{-- <img src= "{{ asset('assets/images/logo-con-nombre.png')}}"  alt="Logo de la Empresa" class="logo"> --}}
                <img src="https://i.ibb.co/nB1BLnf/logo-con-nombre.jpg"  alt="Logo de la Empresa4" class="logo">
                <h1 class="event-name">{{ $nombreEvento }}</h1>
            </div>
                <div class="ticket-body">
                    <div class="row">
                        <div class="col-md-8">
                        <h3>Detalles del Evento</h3>
                        <p><strong>Entrada nro:</strong> {{$numeroEntrada}}</p>
                        <p><strong>Fecha y hora:</strong> {{$fechaEvento}}, {{$horaEvento}} hs </p>
                        <p><strong>Ubicación:</strong> {{$ciudad}},{{$lugarEvento}}</p>
                        <p><strong>Tipo de entrada y precio:</strong> {{$tipoTicket}} - ${{number_format($precioTicket,2)}}</p>
                        <p><strong>Pedido por:</strong> {{$nombreCliente}}</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('verMisEntradas') }}" class="btn-custom">Ver mis entradas</a>
                    </div>
                </div>
                <div class="ticket-body">
                    <h4>Información Importante</h4>
                    <p class="justified-paragraph">Esta es su entrada para el evento. Los asistentes deben presentar sus entradas al ingresar. Puede imprimir su entrada o presentar esta versión digital.</p>
                    <p class="justified-paragraph">Puede encontrar todos los detalles sobre este evento en nuestro sitio web. Si tiene alguna pregunta o necesita un reembolso, comuníquese con soporte técnico.</p>
                    <p><strong>Fecha de compra:</strong> {{$fechaCompra}}</p>
                </div>
                   <!-- Footer -->
                <footer class="text-center mt-4">
                    <p class="text-muted">© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
                </footer>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>