<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="Vladimir Ernesto Moreno Quijano">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EPLI - ADMINISTRACIÓN</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        
	    <link rel="icon" type="image/png" href="{{ asset('img/ventana2.png') }} "/>

		<link href="{{ asset('css/basico/plantilla/sb-admin-2.min.css') }}" rel="stylesheet">

		<link href="{{ asset('css/basico/font-awesome/all.min.css') }}" rel="stylesheet">

		<link href="{{ asset('css/basico/fake-loader/fakeLoader.min.css') }}" rel="stylesheet">

		<link href="{{ asset('css/basico/sweet-alert/sweetalert2.css') }}" rel="stylesheet">

		<link href="{{ asset('css/basico/font-google/font-google.css') }}" rel="stylesheet">
		
		<!-- SWEET ALERT -->
		<script src="{{ asset('js/basico/sweet-alert/sweetalert2.all.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('css/personalizado/style.css') }}">

    </head>
    <body id="page-top" class="bg-gradient-primary">
        
        @yield('content')
		
		@section('content')

        <!-- JQUERY -->
	    <script src="{{ asset('js/basico/jquery/jquery-3.6.0.min.js') }}"></script>
					
		<!-- BOOTSTRAP -->
		<script src="{{ asset('js/basico/bootstrap/bootstrap.bundle.min.js') }}"></script>

		<!-- JS DE LA PLANTILLA -->
		<script src="{{ asset('js/basico/plantilla/sb-admin-2.min.js') }}"></script>

		<!-- FAKE LOADER -->
		<script src="{{ asset('js/basico/fake-loader/fakeLoader.min.js') }}"></script>

		@yield('message')
    </body>
</html>
