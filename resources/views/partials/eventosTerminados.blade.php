<div class="row">
    {{-- COMIENZA FOR EACH EVENTOS TERMINADOS --}}
    @if (isset($eventosTerminados) && $eventosTerminados->isNotEmpty())
        @foreach ($eventosTerminados as $evento)
            <div class="col-md-4">
                <div class="card border-0">
                    <span class="d-inline-flex badge bg-primary position-absolute top-0 ms-2 mt-2 start-0">
                        {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                    </span>
                    <img src="{{ $evento->urlImagen }}" class="animated-image card-img-top img-fluid fixed-size-image"
                        alt="..." />
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">{{ $evento->nombreEvento }}</h5>
                        <p class="card-text">
                        <div class="row">
                            <div class="col">
                                <span class="fw-light"><span class="fw-bold">Categoría:</span>
                                    {{ $evento->categoria->nombreCategoria }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <span class="fw-light"><span class="fw-bold">Ubicación:</span>
                                    {{ $evento->ubicacion->ciudad }}, {{ $evento->ubicacion->direccion }}</span>
                            </div>
                        </div>
                        </p>
                        <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}" class="btn btn-primary">Ver
                            Evento</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No hay eventos finalizados disponibles.</p>
    @endif
</div>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        {{ $eventosTerminados->appends(['page_eventosTerminados' => request('page_eventosTerminados')])->links('pagination::bootstrap-4') }}
    </ul>
</nav>
{{-- 
<div class="container mt-5">
    <div class="row">
        
        @if (isset($eventosTerminados) && $eventosTerminados->isNotEmpty())
            @foreach ($eventosTerminados as $evento)
                <div class="col-md-4">
                    <div class="card border-0">
                        <span class="d-inline-flex badge bg-primary position-absolute top-0 ms-2 mt-2 start-0">
                            {{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('d M Y') }}
                        </span>
                        <img src="{{ $evento->urlImagen }}" class="animated-image card-img-top img-fluid fixed-size-image" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $evento->nombreEvento }}</h5>
                            <p class="card-text">
                                <div class="row">
                                    <div class="col">
                                        <span class="fw-light"><span class="fw-bold">Categoría:</span> {{ $evento->categoria->nombreCategoria }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span class="fw-light"><span class="fw-bold">Ubicación:</span> {{ $evento->ubicacion->ciudad }}, {{ $evento->ubicacion->direccion }}</span>
                                    </div>
                                </div>
                            </p>
                            <a href="{{ route('unEvento', ['idEvento' => $evento->idEvento]) }}" class="btn btn-primary">Ver Evento</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No hay eventos finalizados disponibles.</p>
        @endif
    </div>

    <!-- Enlaces de paginación -->
    <div class="d-flex justify-content-center mt-4">
      
        {{ $eventosTerminados->appends(['page_eventosTerminados' => request('page_eventosTerminados')])->links('pagination::bootstrap-4', ['class' => 'pagination pagination-sm']) }}
    </div>
</div> --}}
