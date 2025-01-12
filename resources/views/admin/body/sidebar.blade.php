<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class=" waves-effect">
                        <i class="ri-home-2-line"></i>
                        <span>Inicio</span>
                    </a>
                </li>

                @auth
                    @if (auth()->user()->hasRole('Admin'))
                        <li>
                            <a href="{{ route('admin.eventos') }}" class=" waves-effect">
                                <i class="ri-calendar-2-line"></i>
                                <span>Eventos</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reportes') }}" class=" waves-effect">
                                <i class="ri-bar-chart-2-line"></i>
                                <span>Reportes</span>
                            </a>
                        </li>
                    @endif
                @endauth

                @auth
                    @if (auth()->user()->hasRole('Cliente'))
                        <li>
                            <a href="{{ route('verMisEntradas') }}" class="waves-effect">
                                <i class="ri-ticket-line"></i>
                                <span>Mis entradas</span>
                            </a>
                        </li>
                    @endif
                @endauth

                <li>
                    <a href="{{ route('admin.verNotificaciones') }}" class="waves-effect">
                        <i class="ri-notification-2-line"></i>
                        <span>Notificaciones</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
