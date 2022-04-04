@extends('template.layout_app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">{{ $titulo }}</h1>
    </div>       
        <form action="{{ route('guardar_elemento') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <input type="hidden" class="form-control" name="service_id" id="service_id" value="{{ $service_id }}" style="display: none;" readonly="true">

                <input type="hidden" class="form-control" name="principal" id="principal" value="1" style="display: none;" readonly="true">

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

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="title">Ingresa el titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el titulo..." autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label for="description">Ingresa la descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="11" style="resize: none;" autocomplete="off" placeholder="Ingresa la descripción..."></textarea>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="main_picture">Seleciona la portada....</label>
                        <input type="file" class="form-control-file" id="main_picture" name="main_picture">
                    </div>

                    @if ( $informacion->link == 1)
                        @if ( $informacion->details != 1)
                            <div class="form-group">
                                <label for="link">Ingresa el link</label>
                                <textarea class="form-control" id="link" name="link" rows="1" style="resize: none;" placeholder="Ingresa el link..."></textarea>
                            </div>
                        @endif
                    @endif

                    @if ( $informacion->document == 1)
                        <div class="form-group">
                            <label for="div_file">Seleciona el documento....</label>
                            <div class="custom-file" id="div_file">
                                <input type="file" class="custom-file-input" id="document_name" name="document_name">
                                <label class="custom-file-label" for="document_name">Selecciona el archivo</label>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            <div class="row pb-10">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-outline-success">AGREGAR</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-info">Volver</a>
                </div>
            </div>

        </form>

@endsection