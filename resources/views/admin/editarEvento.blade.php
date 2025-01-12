@extends('admin.adminMaster')

@section('styles')
    <link href="{{ asset('backend/style/wizardCrearEvento.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Título y navegación -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Modificar Evento</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Eventos</a></li>
                                <li class="breadcrumb-item active">Modificar Evento</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- <form action="{{ route('admin.actualizarEvento', ['id' => $evento->idEvento]) }}" method="POST">
                                @csrf
                                @method('PUT') --}}

                            {{-- <form id="formEvento" method="POST" action="#" enctype="multipart/form-data">
                                @csrf --}}

                                <form id="formEvento" method="POST" action="{{ route('admin.actualizarEvento', ['id' => $evento->idEvento]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                

                                <div class="twitter-bs-wizard">
                                    <div class="wizard-flow-chart">
                                        <span class="fill">1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                    </div>

                                    <!-- DATOS BÁSICOS -->
                                    <section>
                                        <h3 class="text-center mb-4">Datos básicos</h3>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="eventName" class="form-label">Nombre del evento</label>
                                                    {{-- <input type="text" class="form-control" id="eventName"
                                                        name="eventoNombre" value="Evento Ejemplo" required> --}}

                                                        <input type="text" class="form-control" id="nombreEvento" name="nombreEvento" value="{{ $evento->nombreEvento }}" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="idEventoCategoria" class="form-label">Categoría del evento</label>
                                                    <select class="form-select" id="idEventoCategoria" name="eventoCategoria" required>
                                                        <option disabled>Selecciona la categoría</option>
                                                        @foreach ($categorias as $categoria)
                                                            <option value="{{ $categoria->idCategoria }}" {{ $evento->idCategoriaEvento == $categoria->idCategoria ? 'selected' : '' }}>
                                                                {{ $categoria->nombreCategoria }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="eventStartDate" class="form-label">Fecha y hora de realización del evento</label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <!-- Mostrar la fecha formateada -->
                                                            <input type="date" class="form-control" id="eventStartDate"
                                                                name="eventStartDate" 
                                                                value="{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('Y-m-d') }}" 
                                                                required readonly>
                                                        </div>
                                                        <div class="col">
                                                            <!-- Mostrar la hora formateada -->
                                                            <input type="time" class="form-control" id="eventStartTime"
                                                                name="eventStartTime" 
                                                                value="{{ \Carbon\Carbon::parse($evento->fechaRealizacion)->format('H:i') }}" 
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                </div>



                                                
                                            </div>
                                            


                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label for="eventStartDate" class="form-label">Fecha y hora de publicación del evento</label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="date" class="form-control" id="eventStartDate"
                                                                name="eventStartDate" value="{{ \Carbon\Carbon::parse($evento->fechaHabilitacion)->format('Y-m-d') }}"  required readonly>
                                                        </div>
                                                        <div class="col">
                                                            <input type="time" class="form-control" id="eventStartTime"
                                                                name="eventStartTime" value="{{ \Carbon\Carbon::parse($evento->fechaHabilitacion)->format('H:i') }}" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row">
                                        {{-- PAIS --}}
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="selectPaises" class="form-label">Pais</label>
                                        

                                                <select class="form-select" id="selectPaises" name="pais"
                                                autocomplete="off">
                                                <option value="{{$evento->ubicacion->país}}" selected>{{$evento->ubicacion->país}}</option>
                                                @foreach ($paises as $pais)
                                                    <option value="{{ $pais->id }}">{{ $pais->name }}
                                                    </option>
                                                @endforeach
                                                <!-- Aquí debes agregar las opciones de PAises {{$evento->ubicacion->país}}"-->
                                            </select>

                                            </div>
                                        </div>
                                        {{-- PROVINCIA --}}
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="selectProvincias"
                                                    class="form-label">Provincia</label>
                                                <select class="form-select" id="selectProvincias"
                                                    name="provincia">
                                                    <option value="{{$evento->ubicacion->provincia}}" selected>{{$evento->ubicacion->provincia}}</option>
                                                    <!-- Aquí debes agregar las opciones de provincias -->
                                                </select>


                                            </div>
                                        </div>
                                        {{-- LOCALIDAD --}}
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="selectLocalidades"
                                                    class="form-label">Localidad</label>
                                                <select class="form-select" id="selectLocalidades"
                                                    name="localidad">
                                                    <option value="{{$evento->ubicacion->ciudad}}" selected>{{$evento->ubicacion->ciudad}}</option>
                                                    <!-- Aquí debes agregar las opciones de localidades -->
                                                </select>
                                            </div>
                                        </div>
                                        {{-- DIRECCION --}}
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="idDireccion" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="idDireccion"
                                                    name="direccionEvento"
                                                    placeholder="{{$evento->ubicacion->direccion}}", value ="{{$evento->ubicacion->direccion}}">
                                            </div>
                                        </div>
                                    </div>
                                        

                                        <div class="row">
                                        

                                            <div class="row">
                                                {{-- FOTO EVENTO --}}
                                                <div class="col-lg-4">
                                                    <div class="form-group mb-3">
                                                        <label for="idEventoImagen" class="form-label">Imagen del
                                                            evento</label>
                                                        <input name="eventoImagen" class="form-control"
                                                            type="file" id="idEventoImagen"
                                                            onChange="mainThamUrl(this)">
                                                    </div>
                                                </div>

                                                <div class="col-lg">
                                                    <div class="col-sm-10">
                                                        <img id="mainThmb" class="border rounded avatar-lg"
                                                             src="{{ !empty($evento->urlImagen) ? asset($evento->urlImagen) : url('frontend/img/eventos/imagenDefecto/porDefectoEvento.jpg') }}"
                                                             alt="Card image cap">
                                                    </div>
                                                    

                                            </div>
                                            
                                        </div>

                                        <div class="mb-3">
                                            <label for="eventDescription" class="form-label">Descripción del evento</label>
                                            <textarea class="form-control" id="descripcionEvento" name="descripcionEvento" rows="3">{{ $evento->descripcionEvento }}</textarea>
                                            {{-- <textarea class="form-control" id="eventDescription" name="eventDescription" rows="4" required>Descripción de ejemplo del evento.</textarea> --}}
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('backend/js/modificarEvento.js') }}"></script>


    <script>
      /*============================================
            PAISES,  PROVINCIAS Y LOCALIDADES
        ==============================================*/
    
        $(document).ready(function() {

const $selectPaises = $("#selectPaises");
const $selectProvincias = $("#selectProvincias");
const $selectLocalidades = $("#selectLocalidades");

function provincia(paisId) {

    $.ajax({
        url: "{{ url('/crearEvento/provincias/') }}/" + paisId,
        method: "GET",
        success: function(json) {
            let $options = `<option value="">Selecciona la provincia</option>`;

            json.provincias.forEach(function(el) {
                $options += `<option value="${el.id}">${el.name}</option>`;
            });

            $selectProvincias.html($options);
        },
        error: function(jqXHR) {
            let message = jqXHR.statusText || "Ocurrió un error";
            $selectProvincias.next().html(`Error: ${jqXHR.status}: ${message}`);
        }
    });
}

function localidad(provinciaId) {
    $.ajax({
        url: "{{ url('/crearEvento/localidades/') }}/" + provinciaId,
        method: "GET",
        success: function(json) {
            let $options = `<option value="">Selecciona la localidad</option>`;

            json.localidades.forEach(function(el) {
                $options += `<option value="${el.id}">${el.name}</option>`;
            });

            $selectLocalidades.html($options);
        },
        error: function(jqXHR) {
            let message = jqXHR.statusText || "Ocurrió un error";
            $selectLocalidades.next().html(`Error: ${jqXHR.status}: ${message}`);
        }
    });
}

$selectPaises.change(function() {
    provincia($(this).val());
    $selectProvincias.html('<option value="">Selecciona la provincia</option>');
    $selectLocalidades.html('<option value="">Selecciona la localidad</option>');
    //console.log($(this).val());
});

$selectProvincias.change(function() {
    localidad($(this).val());
    //console.log($(this).val());
});

}); 



function mainThamUrl(input) {
    if (input.files && input.files[0]) {
        console.log("Imagen seleccionada"); // Para verificar si la función se ejecuta
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('mainThmb').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}






</script>
@endsection

