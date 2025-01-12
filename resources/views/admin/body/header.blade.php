<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ route('welcome') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-eticket.png') }}" alt="logo-sm-light" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-con-nombre.png') }}" alt="logo-light" height="45">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            {{--     <form class="app-search d-none d-lg-block">
              <div class="position-relative">
                  <input type="text" class="form-control" placeholder="Buscar...">
                  <span class="ri-search-line"></span>
              </div>
          </form> --}}

        </div>

        <div class="d-flex">
            {{-- Pantalla completa --}}
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>
            {{-- menu notificaciones --}}
            @php
                $notifications = auth()->user()->unreadNotifications()->limit(10)->get();
                $notificationCount = $notifications->count();
            @endphp
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    @if ($notifications->isNotEmpty())
                        <span class="noti-dot"></span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notificaciones </h6>
                            </div>
                            <div class="col-auto">
                                <div class="small" style="color: #2b9ed3;">Sin leer (<span class="notification-count">{{ $notificationCount }}</span>)</div>
                            </div>
                        </div>
                    </div>

                    <div data-simplebar style="max-height: 230px;">
                        @if ($notifications->isNotEmpty())
                            @foreach ($notifications as $notification)
                                <a href="#" class="text-reset notification-item">
                                    <div class="d-flex {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}" onclick="markNotificationRead('{{ $notification->id }}')">
                                        <div class="avatar-xs me-3">
                                            @php
                                                $iconClass = 'ri-thumb-up-line'; // Icono por defecto
                                                $bgColor = 'bg-success'; // Color de fondo por defecto

                                                if ($notification->data['type'] === 'event_created') {
                                                    $iconClass = 'ri-calendar-line';
                                                    $bgColor = 'bg-primary';
                                                } elseif ($notification->data['type'] === 'eventoCancelado') {
                                                    $iconClass = 'ri-information-line';
                                                    $bgColor = 'bg-danger';
                                                } elseif ($notification->data['type'] === 'eventoSupendido') {
                                                    $iconClass = 'ri-thumb-down-line';
                                                    $bgColor = 'bg-warning';
                                                } elseif ($notification->data['type'] === 'entradaCreated') {
                                                    $iconClass = 'ri-ticket-2-line';
                                                    $bgColor = 'bg-warning';
                                                }
                                            @endphp

                                            <span class="avatar-title {{ $bgColor }} rounded-circle font-size-16">
                                                <i class="{{ $iconClass }}"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">
                                                {{ $notification->data['title'] ?? 'Nueva Notificación' }}
                                            </h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                    {{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="p-3 d-flex text-muted">
                                <span>No existen notificaciones nuevas</span>
                            </div>
                        @endif

                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <!-- <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)"> -->
                            <a class="btn btn-sm btn-link font-size-14 text-center"
                                href="{{ route('admin.verNotificaciones') }}">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> Ver Más..
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Menu usuario --}}
            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('path_to_images/' . auth()->user()->profileImage) }}"
                        alt="{{ auth()->user()->name }}" class="img-thumbnail mt-3" width="30">
                    <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('welcome') }}"><i
                            class=" ri-home-line align-middle me-1"></i>
                        Principal</a>
                    <a class="dropdown-item" href="{{ route('perfil') }}"><i
                            class="ri-pencil-line align-middle me-1"></i>
                        Perfil</a>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i
                            class="ri-shut-down-line align-middle me-1 text-danger"></i> Salir</a>
                    {{-- {{route('admin.logout')}} --}}
                </div>
            </div>

        </div>
    </div>
</header>
