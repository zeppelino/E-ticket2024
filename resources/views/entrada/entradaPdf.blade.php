{{-- vERSION CON ESTILO --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada para {{$nombreEvento}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .container {
            width: 95%;
            margin: 0 auto;
            max-width: 800px;
            padding: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Encabezado */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #003366; /* Azul oscuro */
            color: #fff;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #fff;
        }

        /* Contenedor de tabla para detalles del evento y QR */
        .content-table {
            width: 100%;
            margin-top: 15px;
        }

        .content-table td {
            vertical-align: top;
            padding: 8px;
        }

        .event-details {
            font-size: 13px;
        }

        .qr-code img {
            max-width: 100px;
            height: auto;
        }

        .date-purchase {
            font-size: 12px;
            margin-top: 8px;
        }

        /* Información importante */
        .important-info {
            font-size: 10px;
            color: #4a90e2;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        /* Footer */
        footer {
            width: 100%;
            background-color: #fff;
            color: #000;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Encabezado -->
    <div class="header">
        <img src="{{ $logo }}" alt="Logo de la Empresa" class="logo">
        <h1 class="event-name">{{ $nombreEvento }}</h1>
    </div>

    <!-- Contenido principal -->
    <table class="content-table">
        <tr>
            <!-- Detalles del evento -->
            <td class="event-details" style="width: 70%;">
                <h3>Detalles del Evento</h3>
                <p><strong>Entrada nro:</strong> {{$numeroEntrada}}</p>
                <p><strong>Fecha y hora:</strong> {{$fechaEvento}}, {{$horaEvento}}hs </p>
                <p><strong>Ubicación:</strong> {{$ciudad}}, {{$lugarEvento}}</p>
                <p><strong>Tipo de entrada y precio:</strong> {{$tipoTicket}} - ${{number_format($precioTicket,2)}}</p>
                <p><strong>Pedido por:</strong> {{$nombreCliente}}</p>
            </td>

            <!-- QR y Fecha de Compra -->
            <td class="qr-section" style="width: 30%; text-align: right;">
                <div class="qr-code">
                    <img src="data:image/png;base64,{{ $qrcode }}" alt="Código QR">
                </div>
                <p class="date-purchase"><strong>Fecha de compra:</strong> {{$fechaCompra}}</p>
            </td>
        </tr>
    </table>

    <!-- Información importante -->
    <div class="important-info">
        <div class="mt-4">
            <h4>Información Importante</h4>
            <p>Esta es su entrada para el evento. Los asistentes deben presentar sus entradas al ingresar. Puede imprimir su entrada o presentar esta versión digital.</p>
            <p>Puede encontrar todos los detalles sobre este evento en nuestro sitio web. Si tiene alguna pregunta o necesita un reembolso, comuníquese con soporte técnico.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

{{-- VERSION MINIMALISTA --}}

{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada para {{$nombreEvento}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .container {
            width: 95%;
            margin: 0 auto;
            max-width: 800px;
            padding: 15px;
            border: 1px solid #f8f8f8;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Encabezado */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            /* background-color: #003366; //Azul oscuro */ 
            background-color: #fff; 
            color: #003366;
            border-bottom: 1px solid #4a90e2;
        }

        .header img {
            height: 70px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #003366;
        }

        /* Contenedor de tabla para detalles del evento y QR */
        .content-table {
            width: 100%;
            margin-top: 15px;
        }

        .content-table td {
            vertical-align: top;
            padding: 8px;
        }

        .event-details {
            font-size: 13px;
        }

        .qr-code img {
            max-width: 100px;
            height: auto;
        }

        .date-purchase {
            font-size: 12px;
            margin-top: 8px;
        }

        /* Información importante */
        .important-info {
            font-size: 10px;
            color: #4a90e2;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        /* Footer */
        footer {
            width: 100%;
            background-color: #fff;
            color: #000;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Encabezado -->
    <div class="header">
        <img src="{{ $logo }}" alt="Logo de la Empresa" class="logo">
        <h1 class="event-name">{{ $nombreEvento }}</h1>
    </div>

    <!-- Contenido principal -->
    <table class="content-table">
        <tr>
            <!-- Detalles del evento -->
            <td class="event-details" style="width: 70%;">
                <h3>Detalles del Evento</h3>
                <p><strong>Entrada nro:</strong> {{$numeroEntrada}}</p>
                <p><strong>Fecha y hora:</strong> {{$fechaEvento}}, {{$horaEvento}}hs </p>
                <p><strong>Ubicación:</strong> {{$ciudad}}, {{$lugarEvento}}</p>
                <p><strong>Tipo de entrada y precio:</strong> {{$tipoTicket}} - ${{$precioTicket}}</p>
                <p><strong>Pedido por:</strong> {{$nombreCliente}}</p>
            </td>

            <!-- QR y Fecha de Compra -->
            <td class="qr-section" style="width: 30%; text-align: right;">
                <div class="qr-code">
                    <img src="data:image/png;base64,{{ $qrcode }}" alt="Código QR">
                </div>
                <p class="date-purchase"><strong>Fecha de compra:</strong> {{$fechaCompra}}</p>
            </td>
        </tr>
    </table>

    <!-- Información importante -->
    <div class="important-info">
        <div class="mt-4">
            <h4>Información Importante</h4>
            <p>Esta es su entrada para el evento. Los asistentes deben presentar sus entradas al ingresar. Puede imprimir su entrada o presentar esta versión digital.</p>
            <p>Puede encontrar todos los detalles sobre este evento en nuestro sitio web. Si tiene alguna pregunta o necesita un reembolso, comuníquese con soporte técnico.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>© {{ date('Y') }} E-Ticket. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 --}}