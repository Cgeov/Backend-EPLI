
@extends('template.layout_app')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <p class="text-center" style="font-size: 50px;"> 
        ** ESPACIO PARA FUTURAS ACTUALIZACIONES **
    </p>

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