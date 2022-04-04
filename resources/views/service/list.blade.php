@extends('template.layout_app')

@section('content') 

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Gestión de servicios</h1>
    </div> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success">Cantidad de servicios : {{ $cantidad }}</h1>
    </div> 

    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <button type="button" class="btn btn-outline-success" id="abrirModalAgregarServicio">
                    Agregar Servicio
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-info">Volver</a>
            </div>
        </div>
    </div>

    {{-- AQUI SE MUESTRAN LAS ALERTAS DE ERRORES O ÉXITO --}}

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

    {{-- CONTENIDO PRINCIPAL --}}

    <div class="row mt-6">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Servicio</th>
                        <th scope="col">Icono</th>
                        <th scope="col">Imágenes</th>
                        <th scope="col">Link</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $contador = 1;
                    @endphp
                    @foreach ($servicios as $servicio)
                        <tr>
                            <th scope="row">{{ $contador }}</th>
                            <td>{{ $servicio->service_name }}</td>
                            <td><i class="{{ $servicio->service_icon }}" style="font-size: 25px;"></i></td>
                            <td>@php ($servicio->slider == 0) ? print 'No' : print 'Sí' @endphp </td>
                            <td>@php ($servicio->link == 0) ? print 'No' : print 'Sí' @endphp </td>
                            <td>@php ($servicio->document == 0) ? print 'No' : print 'Sí' @endphp </td>
                            <td>@php ($servicio->details == 0) ? print 'No' : print 'Sí' @endphp </td>
                            <td>
                                <a href="{{ route('edit_service_view', [ 'id_service' => $servicio->id]) }}" style="color:green; font-size: 25px; margin-right: 10px;"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('delete_service_view', [ 'id_service' => $servicio->id]) }}" style="color: red; font-size: 25px;"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                        @php
                            $contador++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br><br>

    <!-- Modal -->
    <div class="modal fade" id="modal_agregar_servicio" tabindex="-1" aria-labelledby="modal_agregar_servicio" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add_service') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="service_code">Código del servicio</label>
                                    <input type="text" class="form-control" name="service_code" id="service_code" placeholder="Código del servicio" autocomplete="off" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="service_code">Opción de agregar</label>
                                    <input type="text" class="form-control" name="add" id="add" placeholder="Opción de agregar" autocomplete="off">
                                    <input type="hidden" class="form-control" name="add_code" id="add_code" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="service_code">Opción de listar</label>
                                    <input type="text" class="form-control" name="list" id="list" placeholder="Opción de listar" autocomplete="off">
                                    <input type="hidden" class="form-control" name="list_code" id="list_code" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="service_name">Nombre del servicio</label>
                                    <input type="text" class="form-control" name="service_name" id="service_name" placeholder="Nombre del servicio" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="service_icon">Icono del servicio <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank" style="color:blue;">Obtener icono</a></label>
                                    <input type="text" class="form-control" name="service_icon" id="service_icon" placeholder="Icono del servicio" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="slider" id="slider">
                                    <label class="form-check-label" for="slider">
                                        Slider
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="link" id="link">
                                    <label class="form-check-label" for="link">
                                        Link
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="document" id="document">
                                    <label class="form-check-label" for="document">
                                        Documento
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="details" id="details">
                                    <label class="form-check-label" for="details">
                                        Detalles
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cerrarModalAgregarServicio">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('modal_open')
        <script>
            $('#abrirModalAgregarServicio').on('click', function(){
                $('#service_name').focus();
                $('#modal_agregar_servicio').modal('show')
            });

            $('#cerrarModalAgregarServicio').on('click', function(){
                $('#modal_agregar_servicio').modal('hide')
            });
        </script>

        <script>

            $('#service_name').on('keyup', function(){

                var service_name = this.value;

                var replaced = service_name.split(' ').join('_');

                var partes = service_name.split(' ');

                $('#service_code').val(replaced.toLowerCase());

                $('#add').val('Agregar ' + partes[0].toLowerCase());

                var add_name = $('#add').val();

                var replaced_add_name = add_name.split(' ').join('_');

                $('#add_code').val(replaced_add_name.toLowerCase());

                $('#list').val(partes[0] + ' agregados');

                var list_name = $('#list').val();

                var replaced_list_name = list_name.split(' ').join('_');

                $('#list_code').val(replaced_list_name.toLowerCase());
                
            });

            $('#add').on('keyup', function(){

                var add_name = this.value;

                var replaced_add_name = add_name.split(' ').join('_');

                $('#add_code').val(replaced_add_name.toLowerCase());

            });

            $('#list').on('keyup', function(){

                var list_name = this.value;

                var replaced_list_name = list_name.split(' ').join('_');

                $('#list_code').val(replaced_list_name.toLowerCase());

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
                        <a class="btn btn-danger" href="{{ route('confirm_delete_service', ['id_service' => Session::get('eliminar') ]) }}">Eliminar</a>
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

    @if (Session::get('editar'))

            @php
                $informacion = Session::get('informacion');
                $add = Session::get('add');
                $list = Session::get('list');
            @endphp

        <!-- Modal -->
        <div class="modal fade" id="modal_edit_service" tabindex="-1" aria-labelledby="modal_edit_service" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('edit_service') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="service_code">Código del servicio</label>
                                        <input type="text" class="form-control" name="edit_service_code" id="edit_service_code" placeholder="Código del servicio" autocomplete="off" readonly="true" value="{{ $informacion->service_code }}">
                                        <input type="hidden" class="form-control" name="service_id" id="service_id" autocomplete="off" readonly="true" value="{{ $informacion->id }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="service_code">Opción de agregar</label>
                                        <input type="text" class="form-control" name="edit_add" id="edit_add" placeholder="Opción de agregar" autocomplete="off" value="{{ $add->service_option_name }}">
                                        <input type="hidden" class="form-control" name="edit_add_code" id="edit_add_code" autocomplete="off" value="{{ $add->service_option_code }}">
                                        <input type="hidden" class="form-control" name="edit_id_add" id="edit_id_add" autocomplete="off" value="{{ $add->id }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <label for="service_code">Opción de listar</label>
                                        <input type="text" class="form-control" name="edit_list" id="edit_list" placeholder="Opción de listar" autocomplete="off" value="{{ $list->service_option_name }}">
                                        <input type="hidden" class="form-control" name="edit_list_code" id="edit_list_code" autocomplete="off" value="{{ $list->service_option_name }}">
                                        <input type="hidden" class="form-control" name="edit_id_list" id="edit_id_list" autocomplete="off" value="{{ $list->id }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="service_name">Nombre del servicio</label>
                                        <input type="text" class="form-control" name="edit_service_name" id="edit_service_name" placeholder="Nombre del servicio" autocomplete="off" value="{{ $informacion->service_name }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="service_icon">Icono del servicio <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank" style="color:blue;">Obtener icono</a></label>
                                        <input type="text" class="form-control" name="edit_service_icon" id="edit_service_icon" placeholder="Icono del servicio" autocomplete="off" value="{{ $informacion->service_icon }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        @if ($informacion->slider)
                                            <input class="form-check-input" type="checkbox" name="edit_slider" id="edit_slider" value="1" checked >
                                        @else
                                            <input class="form-check-input" type="checkbox" name="edit_slider" id="edit_slider" value="0">
                                        @endif
                                        <label class="form-check-label" for="edit_slider">
                                            Slider
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        @if ($informacion->link)
                                            <input class="form-check-input" type="checkbox" name="edit_link" id="edit_link" value="1" checked >
                                        @else
                                            <input class="form-check-input" type="checkbox" name="edit_link" id="edit_link" value="0">
                                        @endif
                                        <label class="form-check-label" for="edit_link">
                                            Link
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        @if ($informacion->document)
                                            <input class="form-check-input" type="checkbox" name="edit_document" id="edit_document" value="1" checked >
                                        @else
                                            <input class="form-check-input" type="checkbox" name="edit_document" id="edit_document" value="0">
                                        @endif
                                        <label class="form-check-label" for="edit_document">
                                            Documento
                                        </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check">
                                        @if ($informacion->details)
                                            <input class="form-check-input" type="checkbox" name="edit_details" id="edit_details" value="1" checked >
                                        @else
                                            <input class="form-check-input" type="checkbox" name="edit_details" id="edit_details" value="0">
                                        @endif
                                        <label class="form-check-label" for="edit_details">
                                            Detalles
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cerrarModalEditarServicio">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Editar servicio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @section('modal_delete')
            <script>
                $('#modal_edit_service').modal('show');
                $('#cerrarModalEditarServicio').on('click', function(){
                    $('#modal_edit_service').modal('hide');
                });
            </script>

            <script>

                $('#edit_service_name').on('keyup', function(){
    
                    var service_name = this.value;
    
                    var replaced = service_name.split(' ').join('_');
    
                    var partes = service_name.split(' ');
    
                    $('#edit_service_code').val(replaced.toLowerCase());
    
                    $('#edit_add').val('Agregar ' + partes[0].toLowerCase());
    
                    var add_name = $('#edit_add').val();
    
                    var replaced_add_name = add_name.split(' ').join('_');
    
                    $('#edit_add_code').val(replaced_add_name.toLowerCase());
    
                    $('#edit_list').val(partes[0] + ' agregados');
    
                    var list_name = $('#edit_list').val();
    
                    var replaced_list_name = list_name.split(' ').join('_');
    
                    $('#edit_list_code').val(replaced_list_name.toLowerCase());
                    
                });
    
                $('#edit_add').on('keyup', function(){
    
                    var add_name = this.value;
    
                    var replaced_add_name = add_name.split(' ').join('_');
    
                    $('#edit_add_code').val(replaced_add_name.toLowerCase());
    
                });
    
                $('#edit_list').on('keyup', function(){
    
                    var list_name = this.value;
    
                    var replaced_list_name = list_name.split(' ').join('_');
    
                    $('#edit_list_code').val(replaced_list_name.toLowerCase());
    
                });
    
            </script>
        @endsection

    @endif

@endsection