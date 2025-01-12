<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - Mercado Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --mp-blue: #009ee3;
            --mp-yellow: #ffe600;
        }
        body {
            background-color: #f5f5f5;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: var(--mp-blue);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background-color: var(--mp-blue);
            border-color: var(--mp-blue);
        }
        .btn-primary:hover {
            background-color: #0077b3;
            border-color: #0077b3;
        }
        .form-control:focus {
            border-color: var(--mp-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 158, 227, 0.25);
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img src="https://http2.mlstatic.com/frontend-assets/ui-navigation/5.18.9/mercadopago/logo__large@2x.png" alt="Mercado Pago Logo" class="logo img-fluid mx-auto d-block">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center mb-0">Información de Pago</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('resultadoCompra', ['evento' => $evento -> idevento, 'tipoTicket' => $tipoTicket -> idTipoTicket, 'usuario' => $user -> id, 'gratuito' => 0]) }}" method="GET">
                            
                            <input type="hidden" name="evento" value="{{ $evento->idEvento }}">
                            <input type="hidden" name="tipoTicket" value="{{ $tipoTicket->idTipoTicket }}">
                            <input type="hidden" name="usuario" value="{{ $user->id }}">
                            <input type="hidden" name="enlaceCompra" value="{{ $enlaceCompra}}">



                             <h4 class="mb-3">Datos del Cliente</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" placeholder="Apellido" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Calle, número, ciudad" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pais" class="form-label">País</label>
                                    <select class="form-select" id="pais" required>
                                        <option value="">Selecciona tu país</option>
                                        <option value="AR">Argentina</option>
                                        <option value="BR">Brasil</option>
                                        <option value="CL">Chile</option>
                                        <option value="CO">Colombia</option>
                                        <option value="MX">México</option>
                                        <option value="PE">Perú</option>
                                        <option value="UY">Uruguay</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="provincia" class="form-label">Estado/Provincia</label>
                                    <input type="text" class="form-control" id="provincia" placeholder="Provincia/Estado" required>
                                </div>
                            </div>

                            <h4 class="mb-3 mt-4">Datos de Pago</h4>
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Nombre como aparece en la tarjeta</label>
                                <input type="text" class="form-control" id="cardName" placeholder="Nombre en la tarjeta" required>
                            </div>
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiryDate" class="form-label">Fecha de Expiración</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/AA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                </div>
                            </div> 
                            <div class="d-grid gap-2 mt-4">                                
                                <!-- Botón de comprar -->
                                <button type="submit" class="btn btn-primary btn-lg">Pagar de forma segura</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>