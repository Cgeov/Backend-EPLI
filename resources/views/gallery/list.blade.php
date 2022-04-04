@extends('template.layout_app')

@section('content') 

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Imágenes para >> {{ LimitarCadena::limitar($titulo, 50, "...") }}</h1>
    </div> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success">Cantidad de imágenes agregadas : {{ $cantidad }}</h1>
    </div> 

    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <button type="button" class="btn btn-outline-success" id="abrirModalAgregarImagen">
                    Agregar Imagen
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-info">Volver</a>
            </div>
        </div>
    </div>

    <div class="row">
        @if (Session::get('errores'))
            <div class="col-12 mt-5">
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

        @if (Session::get('message'))
            <div class="col-12 mt-5">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        
        @foreach ($informacion as $item)

            <div class="col-xl-3 col-md-3 col-sm-12" style="margin: 20px 0px;">
                <div class="card border-success mb-3">
                    <div class="card">
                        @if ($item->image_name)
                            <img src="{{ route('get_image_gallery', ['id_image_type'=> $item->image_name] ) }}" style="height: 250px; width: 100%; border-radius: 5px;">
                        @else
                            <img src="..." alt="...">
                        @endif
                        <div class="card-body text-center">
                            <form action="{{ route('delete_image_gallery') }}" method="post">
                                @csrf
                                <input type="hidden" name="gallery_id" id="gallery_id" value="{{ $item->id }}" readonly="true">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> <strong>Eliminar</strong>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
        
    </div>

    <div class="row">
        <div class="col-12">
            {{ $informacion->links() }}
        </div>
    </div>
    <br><br>

    <!-- Modal -->
    <div class="modal fade" id="modal_agregar_imagen" tabindex="-1" aria-labelledby="modal_agregar_imagen" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Imagen >>  {{ $titulo }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('save_image_gallery') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_image_type" id="id_image_type" value="{{ $principal->id }}" readonly="true">
                        <div class="mb-3">
                            <label for="image_name" class="form-label">Selecciona la imagen</label>
                            <input class="form-control" type="file" name="image_name" id="image_name" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cerrarModalAgregarImagen">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar imagen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('modal_open')
        <script>
            $('#abrirModalAgregarImagen').on('click', function(){
                $('#modal_agregar_imagen').modal('show')
            });

            $('#cerrarModalAgregarImagen').on('click', function(){
                $('#modal_agregar_imagen').modal('hide')
            });
        </script>
    @endsection

    @if (Session::get('eliminar'))

        <!-- Modal -->
        <div class="modal fade" id="modal_delete_service_information" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Dato Seleccionado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h2>Realmente deseas eliminarlo?</h2>
                        <h2>
                            Al eliminarlo ya no aparecerá en el sitio público y tampoco se podrá recuperar 
                            y tendrás que ingresar toda la información nuevamente
                        </h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-danger" href="{{ route('confirm_delete_service_information', ['service_information' => Session::get('eliminar') ]) }}">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
        @section('modal_delete')
            <script>
                $('#modal_delete_service_information').modal('show')
            </script>
        @endsection

    @endif

@endsection