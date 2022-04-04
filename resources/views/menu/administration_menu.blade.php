<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3 text-center">EPLI</div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <!-- Nav Item - HOME -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Home</span></a>
    </li>

    @php
        $services = GetMenu::ObtenerMenu()
    @endphp

    @foreach ($services as $service)
        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <!-- Nav Item - PUBLICACIONES Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="{{ '#'. $service->service_code }}"
                aria-expanded="true" aria-controls="{{ $service->service_code }}">
                <i class="{{ $service->service_icon }}"></i>
                <span>{{ $service->service_name }}</span>
            </a>
            <div id="{{ $service->service_code }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded">
                    <h6 class="collapse-header text-white">Opciones:</h6>
                    @foreach ($service->service_options as $options)
                        <a class="collapse-item" href="{{ route('action', [ 'detailaction'=> $options->action , 'detailservice'=> $options->service_option_code] ) }}">{{ $options->service_option_name }}</a>
                    @endforeach
                </div>
            </div>
        </li>
    @endforeach
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Nav Item - GALERÍA Collapse Menu -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGaleria" aria-expanded="true"
            aria-controls="collapseGaleria">
            <i class="fas fa-camera-retro"></i>
            <span>Galería</span>
        </a>
        <div id="collapseGaleria" class="collapse" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                @php
                    $imageType = GetMenu::ObtenerTipoGaleria()
                @endphp
                @foreach ($imageType as $image)
                    @if ($image->image_type_code === 'capacitaciones_y_sensibilizaciones')
                        <a class="collapse-item" href="{{ route('image_management', [ 'id_image_type'=> $image->image_type_code ] ) }}">Capacitaciones y <br>sensibilizaciones</a>
                    @else
                        <a class="collapse-item" href="{{ route('image_management', [ 'id_image_type'=> $image->image_type_code ] ) }}">{{ $image->image_type }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
    </ul>
    <!-- End of Sidebar -->