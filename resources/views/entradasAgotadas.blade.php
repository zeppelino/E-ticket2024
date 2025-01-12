@extends('layouts.header')

@section('content')
<body>
  <div class="container text-center mt-5">
      <div class="alert alert-warning" role="alert">
          <h1 class="display-4">Entradas Agotadas</h1>
          <p class="lead">Lamentablemente, todas las entradas para este evento se han agotado.</p>
          <hr class="my-4">
          <p>Te invitamos a explorar otros eventos disponibles en nuestra plataforma.</p>
      </div>
      <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg mt-3">
          Volver a la Página de Inicio
      </a>
  </div>

</body>
@endsection