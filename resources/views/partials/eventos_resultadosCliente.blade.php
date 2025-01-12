@if(isset($titulo))
    <h2>{{ $titulo }}</h2> <!-- Mostrar el título si está definido -->
@endif

@if(isset($eventos) && $eventos  && $eventos->isEmpty())
    <p>No se encontraron eventos.</p>
@elseif(isset($eventos))
    <ul class="list-group">
        @foreach($eventos as $evento)
          <div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="row">
            <!-- Imagen del evento -->
            <div class="col-md-2 text-center">
                <img src="{{ ($evento->urlImagen) }}" alt="Imagen del evento" class="img-fluid rounded">
            </div>
            <!-- Detalles del evento -->
            <div class="col-md-9">
                <h5 class="card-title"><strong>Evento: {{ $evento->nombreEvento }}</strong></h5>
                <p class="card-text text-muted">Categoría: {{ $evento->categoria->nombreCategoria }}</p>
                <!-- Mostrar la fecha de realización del evento -->
                <p class="card-text text-muted">Fecha: {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}</p>
                <p class="card-text"><strong>Ubicación:</span> {{ $evento->ubicacion->ciudad }} , {{ $evento->ubicacion->direccion }}</p>
                <div class="text-center mb-5">
                    <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}" class="btn btn-primary">Ver Evento</a>
                </div>
            </div>
        </div>
    </div>
</div>
        @endforeach
    </ul>
@else
    <p>Utiliza el buscador para encontrar eventos.</p>
@endif

