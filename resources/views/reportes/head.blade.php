<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
        }

        /*   .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .header img {
            height: 60px;
        }
        .header .date {
            font-size: 14px;
            text-align: right;
        } */



        h1 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 40px;
            color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #777;
        }

        table td.numeric {
            text-align: right;
        }
    </style>
</head>

<body>
    <div style="background-color: black; color: white; padding: 15px; border-radius: 5px;">
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tr>
                <!-- Logo -->
                <td style="width: 30%; text-align: left; vertical-align: middle; border: none;">
                    <img src="../public/assets/images/logo-con-nombre.png" alt="Logo E-TICKET" style="height: 60px;">
                </td>

                <!-- Información -->
                <td style="width: 70%; text-align: right; vertical-align: middle; border: none;">
                    <p style="margin: 0; font-size: 16px; font-weight: bold;">E-Ticket Eventos</p>
                    <p style="margin: 0; font-size: 14px;">www.e-ticket.com</p>
                    <p style="margin: 0; font-size: 14px;">Fecha del reporte:
                        {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
    </div>


    @yield('contenido')



    <div class="footer">
        <p>Este es un reporte generado automáticamente. &copy; {{ date('Y') }} Empresa E-ticket. Todos los derechos
            reservados.</p>
    </div>

    <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Roboto, Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 800, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
    </script>

</body>

</html>
