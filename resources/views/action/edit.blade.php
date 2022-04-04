@extends('template.layout_app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Editando >> {{ LimitarCadena::limitar($information->title, 50, "...") }}</h1>
    </div>       
        <form action="{{ route('editar_elemento')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <input type="hidden" class="form-control" name="service_information_id" id="service_information_id" value="{{ $information->id }}" style="display: none;">

                @if (Session::get('errores'))
                    <div class="col-12">
                        @foreach (Session::get('errores') as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $error }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="col-lg-5">

                    <div class="form-group">
                        <label for="title">Nuevo titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el titulo..." autocomplete="off" value="{{ $information->title }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Nuva descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="11" style="resize: none;" autocomplete="off" placeholder="Ingresa la descripción...">{{ $information->description }}</textarea>
                    </div>

                </div>

                <div class="col-lg-7">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <label for="mostrarPortada">Portada actual</label>
                                <img id="mostrarPortada" src="{{ route('get_image', ['filename'=> $information->main_picture] ) }}" style="height: 250px; width: 100%">
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="main_picture">Cambiar la portada....</label>
                                    <input type="file" class="form-control-file" id="main_picture" name="main_picture">
                                </div>
                            </div>
                        </div>
                        @if ( $informacion->document == 1)
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <label for="mostrarPortada">Documento actual</label>
                                    <img id="mostrarPortada" src="{{ route('get_image', ['filename'=> $information->main_picture] ) }}" style="height: 250px; width: 100%">
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label for="main_picture">Cambiar la documento....</label>
                                        <input type="file" class="form-control-file" id="main_picture" name="main_picture" value="{{ $information->main_picture }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ( $informacion->link == 1)
                        <div class="form-group">
                            <label for="link">Modifica el link</label>
                        <textarea class="form-control" id="link" name="link" rows="2" style="resize: none;" placeholder="Ingresa el link...">{{ $information->link }}</textarea>
                        </div>
                    @endif

                </div>

            </div>

            <div class="row pb-10">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-outline-success">Actualizar Información</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-info">Volver</a>
                </div>
            </div>

        </form>

@endsection