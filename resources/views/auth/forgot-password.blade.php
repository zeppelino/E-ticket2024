<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8" />
    <title>Recuperar Contraseña | E-Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
  {{--   <link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
  <link rel="stylesheet" href="{{ asset('backend/style/styleLogReg.css') }}">

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

                    <h4 class="text-muted text-center font-size-18"><b>Recuperar Contraseña</b></h4>

                    <div class="p-3">
                        <form class="form-horizontal mt-3" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                Ingrese a su <strong>E-mail</strong> y siga las instrucciones enviadas !
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-xs-12">
                                    <input class="form-control" type="email" id="email" name="email"
                                        required="" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group pb-2 text-center row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Enviar
                                        Email</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

</body>

</html>

