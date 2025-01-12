@extends('admin.adminMaster')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Perfil del Usuario</h4>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" >
                                {{-- CSRF Protection --}}
                                @csrf
                                
                                {{-- Nombre --}}
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="{{ auth()->user()->name }}" pattern="[A-Za-zÀ-ÿ\s]+">
                                </div>

                                {{-- Apellido --}}
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido"
                                        value="{{ auth()->user()->lastName }}" pattern="[A-Za-zÀ-ÿ\s]+">
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ auth()->user()->email }}" readonly>
                                </div>
                                {{-- Contraseña Actual --}}
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" name="current_password" placeholder="Contraseña actual" autocomplete="new-password">
                                    @error('current_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Contraseña Nueva --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                            placeholder="Dejar en blanco para mantener la actual">
                                            @error('password')
                                       <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror
                                    </div>
                                </div>

                                {{-- Confirmacion de Contraseña Nueva --}}
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"
                                             placeholder="Confirmar contraseña">
                                            @error('password_confirmation')
                                       <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror
            
                                    </div>
                                </div>

                                @if (auth()->user()->profileImage)
                                        <img src="{{ asset('path_to_images/' . auth()->user()-> profileImage) }}"
                                            alt="Imagen de Perfil" class="img-thumbnail mt-3" width="150">
                                    @endif
                                    <label for="imagen" class="form-label">Imagen de Perfil</label>
                                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" capture="environment">
                                </div>
                                
                                {{-- Botón para guardar --}}
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
   
@endsection
