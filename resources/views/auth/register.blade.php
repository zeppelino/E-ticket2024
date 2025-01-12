<!doctype html>
<html lang="es">

    <head>
        
        <meta charset="utf-8" />
        <title>Registro | E-Ticket</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
      {{--   <link href="{{ asset('assets/css/app.css')}}" id="app-style" rel="stylesheet" type="text/css" /> --}}

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
                                    <img src="{{ asset('assets/images/logo-eticket.png')}}" height="60" class="logo-light mx-auto" alt="">
                                </a>
                            </div>
                        </div>
    
                        <h4 class="text-muted text-center font-size-18"><b>Registro</b></h4>
    
                        <div class="p-3">

                            <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
                                @csrf
                              
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        {{-- <input class="form-control" type="text" id="name" name="name" required="" placeholder="Nombre"> --}}

                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="name" value="{{ old('nombre') }}" placeholder="Nombre">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                       {{--  <input class="form-control" type="text" id="lastName" name="lastName" required="" placeholder="Apellido"> --}}

                                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" id="lastName" value="{{ old('apellido') }}" placeholder="Apellido">
                                        @error('apellido')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                     {{--    <input class="form-control" name="email" id="email" type="email" required="" placeholder="Email"> --}}
                                     <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                                     @error('email')
                                     <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                     @enderror
                                   
                                    </div>
                                </div>
    
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                       {{--  <input class="form-control" type="password" id="password" name="password" required="" placeholder="Contraseña"> --}}
                                       <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Contraseña">
                                       @error('password')
                                       <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                       {{--  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required="" placeholder="Confirmar contraseña"> --}}
                                       <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirmar contraseña">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                            {{--     <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="form-label ms-1 fw-normal" for="customCheck1">Aceptar <a href="#" class="text-muted">Terminos y condiciones</a></label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <span href="#" class="text-muted">(Todos los campos son obligatorios)</span>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group text-center row mt-4 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Registrarse</button>
                                    </div>
                                </div>
    
                                <div class="form-group mt-2 mt-0 row">
                                    <div class="col-12 mt-3 text-center">
                                        <a href="{{ route('login') }}" class="text-muted">¿Ya tienes cuenta?</a>
                                    </div>
                                </div>
                            </form>
                            <!-- end form -->
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
        <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    </body>
</html>
