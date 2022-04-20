
@extends('template.layout_login')

@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <br><br><br>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img class="img-login-administrador" src="{{ asset('img/administrador/login.png') }}" alt="Homepage" >
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h5 text-gray-900 mb-4">¿Olvidaste tu contraseña? <br> No hay problema. Simplemente díganos su dirección de correo electrónico y le enviaremos un enlace para restablecer la contraseña que le permitirá elegir una nueva.</h1>
                                    </div>
                                    @if(session('status'))
                                        <div class="alert alert-success" role= "alert">
                                            ¡Le hemos enviado un correo electrónico con su enlace de restablecimiento de contraseña!
                                        </div>
                                    @endif
                                    @if($errors)
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger" role= "alert">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                    @endif
                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Ingresa el correo por favor....." autocomplete="off" autofocus required>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success btn-block btn-user">RECUPERAR CONTRASEÑA</button>
                                        <a href="{{ route('inicio') }}" class="btn btn-outline-info btn-block btn-user">Volver</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection