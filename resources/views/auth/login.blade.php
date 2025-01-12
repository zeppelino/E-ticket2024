<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8" />
    <title>Iniciar Sesión | E-Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
   {{--  <link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('backend/style/styleLogReg.css') }}">
     <!-- Estilo para borde rojo en input password, evita que se corte por visualizador de password-->
    <link rel="stylesheet" href="{{ asset('backend/style/styleLogin.css') }}">
   
 
</head>

<body class="auth-body-bg">

    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">

                    <div class="text-center mt-4">
                        <div class="mb-3">
                            <a href="{{ route('welcome') }}" class="auth-logo">
                                <img src="{{ asset('assets/images/logo-eticket.png') }}" height="60"
                                    class="logo-dark mx-auto" alt="">
                            </a>
                        </div>
                    </div>

                    <h4 class="text-muted text-center font-size-18"><b>Iniciar Sesión</b></h4>

                    <div class="p-3">
                        <form class="form-horizontal mt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    {{-- <input class="form-control" id="email" name="email" type="email" required="" placeholder="Email"> --}}
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <input type="password" id="password" name="password" class="form-control border-end-0" placeholder="Contraseña"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='ri-eye-off-line'></i></a> --}}
                            <div class="form-group mb-3 row ">
                                <div class="col-12 input-group " id="show_hide_password">
                                    <input type="password"
                                        class="form-control border-end-0 @error('password') is-invalid @enderror "
                                        name="password" id="password" placeholder="Contraseña">
                                    <a href="javascript:;" class="input-group-text bg-transparent @error('password') is-invalid @enderror"><i class='ri-eye-off-line'></i></a>
                                </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        {{-- <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="form-label ms-1" for="customCheck1">Recordarme</label> --}}
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label ms-1 text-muted" for="remember">
                                            Recordarme
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3 text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Iniciar
                                        Sesión</button>
                                </div>
                            </div>

                            <div class="form-group mb-0 row mt-2">
                                <div class="col-sm-7 mt-3">
                                    <a href="{{ route('password.request') }}" class="text-muted"><i
                                            class="mdi mdi-lock"></i> ¿Olvidaste tu contraseña?</a>
                                </div>
                                <div class="col-sm-5 mt-3">
                                    <a href="{{ route('register') }}" class="text-muted"><i
                                            class="mdi mdi-account-circle"></i> Crear una cuenta</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end -->
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end container -->
    </div>
    <!-- end -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  {{--   <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script> --}}

    <script src="{{ asset('backend/js/login.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}

</body>

</html>