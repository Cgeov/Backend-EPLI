@extends('template.layout_app')

@section('content') 

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary">Detalle para >> {{ LimitarCadena::limitar($principal->title, 50, "...") }}</h1>
    </div> 
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success">Detalles agregados : {{ $cantidad }}</h1>
    </div> 

    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <a href="{{ route('add_detail_service', ['id_service_information' => $principal->id]) }}" class="btn btn-outline-success">Agregar detalle</a>
                <a href="{{ url()->previous() }}" class="btn btn-outline-info">Volver</a>
            </div>
        </div>
    </div>

    <div class="row">
        
        @foreach ($detalles as $item)

            <div class="col-xl-6 col-md-6 col-sm-12" style="margin: 20px 0px;">
                <div class="card border-success mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            @if ($item->service_informations->main_picture)
                                <img src="{{ route('get_image', ['filename'=> $item->service_informations->main_picture] ) }}" style="height: 250px; width: 100%">
                            @else
                                <img src="..." alt="...">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><b>Título:</b> {{ $item->service_informations->title }}</h5>
                                <p class="card-text"><b>Descripción:</b> {{ LimitarCadena::limitar($item->service_informations->description, 125, "...") }}</p>
                                <p class="card-text" style="margin-top: 5%;"><small class="text-muted">{{ FormatTime::LongTimeFilter($item->service_informations->created_at) }}</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 options_action">
                            <a href="{{ route('edit_service_information', ['id_service_information' => $item->service_informations->id]) }}" style="font-size: 18px;"><i class="fas fa-edit" style="color: green; font-size: 20px;"></i> Editar</a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 options_action">
                            <a href="{{ route('delete_service_information', ['service_information' => $item->service_informations->id]) }}" style="font-size: 18px;"><i class="fas fa-trash-alt" style="color: red; font-size: 20px;"></i> Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
        
    </div>

    <div class="row">
        <div class="col-12">
            {{ $detalles->links() }}
        </div>
    </div>
    <br><br>

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