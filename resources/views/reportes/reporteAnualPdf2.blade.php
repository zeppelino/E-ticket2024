
    @extends('reportes.head')

    @section('titulo', 'Reporte Eventos')
    
    @section('contenido')
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="display-6" style="color: #35577f; ">Reporte de Eventos Anuales</h1>
            <div style="text-align: center">
                <p class="lead" style="color: #333;">Resumen de ventas y participantes en eventos por año.</p>
            </div>
        </div>
    
        <table class="table table-bordered">
            <thead style="background-color: #4a90e2; color: #fff;">
                <tr class="text-center">
                    <th>Año</th>
                    <th>Cantidad de Eventos</th>
                    <th>Entradas Vendidas</th>
                    <th>Entradas No Vendidas</th>
                    <th>Participantes Sin Entradas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventosResumen as $resumen)
                    <tr class="text-center">
                        <td style="background-color: #f2f7fb; color: #333;">{{ $resumen['anio'] }}</td>
                        <td style="background-color: #dff0e8; color: #333;">{{ $resumen['cantidadEventos'] }}</td>
                        <td style="background-color: #e8f5e9; color: #388e3c;">{{ $resumen['entradasVendidas'] }}</td>
                        <td style="background-color: #ffe6e6; color: #c62828;">{{ $resumen['entradasNoVendidas'] }}</td>
                        <td style="background-color: #f3e5f5; color: #6a1b9a;">{{ $resumen['sinEntradas'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @endsection()

