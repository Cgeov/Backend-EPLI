
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
                                        <h1 class="h4 text-gray-900 mb-4">Hola como estas :3 ?</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Ingresa el correo por favor....." autocomplete="off" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Tu contraseña aqui..." autocomplete="current-password" required>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success btn-block btn-user">INGRESEMOS</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('password.request') }}">Olvidaste tu contraseña ? q.q</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('message')
    @if (Session::get('message'))
        <script>
            
            Swal.fire(
                "{{Session::get('tittle')}}",
                "{{Session::get('message')}}",
                "{{Session::get('icon')}}"
            )

        </script>
    @endif
@endsection