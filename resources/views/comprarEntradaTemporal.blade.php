@extends('layouts.header')

@section('content')

<!-- Custom CSS for styling -->
<style>
  .agotado {
      color: grey;
      text-decoration: line-through;
  }
  .card-entry {
      transition: transform 0.2s, box-shadow 0.2s;
  }
  .card-entry:hover {
      transform: scale(1.05);
  }
  .card-entry.selected {
      box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
  }

  .time-unit {
    font-size: 0.7em; /* Tamaño más pequeño */
    color: gray; /* Opcional: cambio de color */
  }
</style>

<body>
<div class="container mt-5">
    
  <p class="text-center">Hola, <strong>{{ $user->name }}</strong>. Estás a punto de comprar una entrada para <strong>{{ $evento->nombreEvento }}</strong>, que se realizará el <strong>{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d/m/Y H:i A') }}</strong>.</p>
  <!-- Temporizador -->
    <div class="text-center mb-4">
        <h2>Tiempo restante para la compra</h2>
            <p id="timer" class="display-4">
                {{ sprintf('%02d : %02d', floor($tiempoRestante / 60), $tiempoRestante % 60) }}
            {{--     {{ sprintf('%02d', floor($tiempoRestante / 60)) }} <span>min</span> :
                {{ sprintf('%02d', $tiempoRestante % 60) }} <span>seg</span> --}}
            </p>
    </div>

  <!-- Selector de Tipo de Entrada -->
    <h3 class="text-center mb-4">Selecciona tu tipo de entrada:</h3>
<form id="seleccionEntradaForm" class="text-center" method="POST" action="{{ route('pasarelaPago') }}">

    @csrf  

    <!-- Campo hidden para enviar el ID del evento -->
    <input type="hidden" name="evento" value="{{ $evento->idEvento }}">
    <input type="hidden" name="usuario" value="{{ $user->id }}">
    <input type="hidden" name="signature" value="{{ request()->query('signature') }}">
    <input type="hidden" name="expires" value="{{ request()->query('expires') }}">
    <input type="hidden" id="generadoEn" name="generadoEn" value="{{ now()->timestamp }}">
    <input type="hidden" name="enlaceCompra" value="{{ request()->fullUrl() }}">


 
    
    <div class="row justify-content-center">

    @forelse ($evento->tipoTickets as $ticket)
    <div class="col-md-4 mb-4">
        <div class="card-entry rounded-4 animated-image p-3 {{ $ticket->cupoDisponible == 0 ? 'agotado' : '' }}">
            <div class="form-check">
                @if ($ticket->cupoDisponible > 0)
                    <!-- Mostrar radio button solo si hay disponibilidad -->
                    <input 
                        class="form-check-input" 
                        type="radio" 
                        name="tipoTicket" 
                        id="entrada_{{ $ticket->idTipoTicket }}" 
                        value="{{ $ticket->idTipoTicket }}" 
                        required
                    >
                @endif
                <label class="form-check-label" for="entrada_{{ $ticket->idTipoTicket }}">
                    <h5>{{ $ticket->categoriaTicket->nombreCatTicket }}</h5>
                    <p>{{ $ticket->descripcionTipoTicket }}</p>

                    @if (isset($ultimoBeneficio))
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted text-decoration-line-through m-0">
                            <strong>Precio:</strong> ${{ number_format($ticket->precioTicket, 2) }}
                        </p>
                        <span class="text-success fw-bold">
                            (-{{ $ultimoBeneficio->porcentaje }}%)
                        </span>
                    </div>
                    <p><strong>Precio con descuento:</strong> 
                        ${{ number_format($ticket->precioTicket - (($ultimoBeneficio->porcentaje * $ticket->precioTicket) / 100), 2) }}
                    </p>
                    @else
                    <p><strong>Precio:</strong> ${{ number_format($ticket->precioTicket, 2) }}</p>
                    @endif

                    {{-- <p><strong>Cantidad:</strong>{{ $ticket -> cupoDisponible}}</p> --}}

                    <p class="{{ $ticket->cupoDisponible > 0 ? 'text-success' : 'text-danger' }}">
                        <strong>Disponibilidad:</strong> 
                        {{ $ticket->cupoDisponible > 0 ? 'Disponible' : 'Agotado' }}
                    </p>
                </label>
            </div>
        </div>
    </div>
    @empty
        <p>No hay tickets disponibles.</p>
    @endforelse

    </div>
    
    <!-- Botón de comprar -->
    <div class="d-grid gap-2 mt-4">
      {{--   <button type="submit" class="btn btn-success btn-lg" 
        @if (!$hayDisponibilidad) 
        disabled    
        @endif>Comprar</button> --}}
        <button type="submit" class="btn btn-success btn-lg" >Comprar</button>
    </div>
</form>
</div>
</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Temporizador JavaScript -->
<script>
    
    const expires = {{ $tiempoRestante }}; // Tiempo restante en segundos
    const generadoEn = parseInt(document.getElementById('generadoEn').value); // En segundos

    console.log('Tiempo restante:', expires);
    console.log('Generado en:', generadoEn);

    const expirationTime = generadoEn + expires; // En segundos

    function updateTimer() {
        const now = Math.floor(Date.now() / 1000); // Convertir a segundos

        const remainingTime = expirationTime - now; // En segundos

        if (remainingTime <= 0) {
            document.getElementById('timer').textContent = '00:00';
            
            const userId = "{{ $user->id }}";
            const eventoId = "{{ $evento->idEvento }}";

        // Construir URL con parámetros
        window.location.href = `{{ route('tiempoExpirado') }}?user=${userId}&evento=${eventoId}`;
            window.location.href = "{{ route('tiempoExpirado') }}";
            /* location.reload(); // Recargar página si el tiempo expira */
        } else {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            //document.getElementById('timer').textContent = `${String(minutes).padStart(2, '0')} min :${String(seconds).padStart(2, '0')} seg`;
            document.getElementById('timer').innerHTML = `
            ${String(minutes).padStart(2, '0')} <span class="time-unit">min</span> :
            ${String(seconds).padStart(2, '0')} <span class="time-unit">seg</span>`
        }
    }

setInterval(updateTimer, 1000);
updateTimer(); // Llamada inicial

  // Agregar clase 'selected' a la tarjeta seleccionada
  document.addEventListener('DOMContentLoaded', function () {
      const cards = document.querySelectorAll('.card-entry');
      const inputs = document.querySelectorAll('input[type="radio"]');

      inputs.forEach(input => {
          input.addEventListener('change', function () {
              // Eliminar la clase 'selected' de todas las tarjetas
              cards.forEach(card => card.classList.remove('selected'));

              // Agregar la clase 'selected' a la tarjeta que contiene el radio button seleccionado
              const selectedCard = this.closest('.card-entry');
              selectedCard.classList.add('selected');
          });
      });
  });


</script>

@endsection
