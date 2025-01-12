@extends('admin.adminMaster')
@section('admin')

  <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4>
                            Notificaciones
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Notificaciones</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                          <table id="dataTableNotificaciones" class="table table-bordered table-striped dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-info">
                                  <tr>
                                      <th style="width: 10px;">#</th> <!-- Nueva columna para el número -->
                                      <th>Descripción</th>
                                      <th>Nombre del Evento</th>
                                      <th>Estado</th>
                                      <th>Fecha y Hora</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @php $counter = 1; @endphp <!-- Inicializa el contador -->
                                  @forelse ($notifications as $notification)
                                      <tr>
                                          <td>{{ $counter++ }}</td> <!-- Muestra y luego incrementa el contador -->
                                          <td>{{ $notification->data['title'] }}</td>
                                          <td>{{ $notification->data['event_name'] ?? 'Evento Desconocido' }}</td>
                                          <td>
                                              @if ($notification->read_at)
                                                  <span class="badge bg-success rounded-pill p-2">Leído</span>
                                              @else
                                                  <span class="badge bg-warning rounded-pill p-2">No Leído</span>
                                              @endif
                                          </td>
                                          <td class="text-end">{{ $notification->created_at->format('d/m/Y') }} --- {{$notification->created_at->format('H:i') }}</td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="5" class="text-center" >No existen notificaciones disponibles.</td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                        </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
  </div>

@endsection

@section('scripts')
    <!--  JS PARA  NOTIFIACIONES -->
   <script src="{{ asset('backend/js/notificaciones.js')}}"></script>
@endsection