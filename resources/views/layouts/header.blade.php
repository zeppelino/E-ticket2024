<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <!-- Link Bootstrap -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    {{-- Link Bootstrap --}}
    <link href="{{ asset('bootstrap5.3.3/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('frontend/style/styleHome.css') }}">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    @yield('style')

    <title>E-Ticket | Eventos</title>
</head>

<body>

    <!-- BARRA NAVEGACION -->
    <nav class="navbar sticky-top bg-dark bg-gradient navbar-expand-sm">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('assets/images/logo-con-nombre.png') }}" class="align-top mb-1" alt="logo-light"
                    height="40">
            </a>
            {{-- Boton para cuando se reduce tamaño de ventana --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="{{ route('welcome') }}">
                            <i class="ri-home-line"></i> Inicio
                        </a>
                    </li>
               {{--      <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <i class="ri-calendar-line"></i> Eventos
                        </a>
                    </li> --}}
                   {{--  <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">
                            <i class="ri-user-add-line"></i> Registrarse
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="ri-login-box-line"></i> Iniciar Sesión
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        @if (Auth::check())
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('path_to_images/' . auth()->user()-> profileImage) }}" alt="{{ auth()->user()->name }}" class="img-thumbnail mt-3" width="30">
                                <span class="d-none d-xl-inline-block ms-1 text-white">{{ auth()->user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block text-white""></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{route('dashboard')}}"><i class="ri-user-line  align-middle me-1"></i>
                                    Mi Cuenta</a>
                                <a class="dropdown-item" href="{{route('perfil')}}"><i class="ri-pencil-line align-middle me-1"></i>
                                    Perfil</a>
                                <a class="dropdown-item text-danger" href="{{route('admin.logout')}}"><i
                                        class="ri-shut-down-line align-middle me-1 text-danger"></i> Salir</a>
                                {{-- {{route('admin.logout')}} --}}
                            </div>
                        </div>
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">
                                <i class="ri-user-add-line"></i> Registrarse
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">
                                <i class="ri-login-box-line"></i> Iniciar Sesión
                            </a>
                        </li>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    @extends('layouts.footer')
