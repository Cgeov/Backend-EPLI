<?php
namespace App\Helpers;

use App\Models\ImageType;
use App\Models\Service;

use Illuminate\Support\Facades\DB;

class GetMenu {

    public static function ObtenerMenu() {
        
        $services = Service::orderBy('id', 'asc')->get();

        return $services;
    }

    public static function ObtenerTipoGaleria(){
        $imageType = ImageType::orderBy('id', 'asc')->get();

        return $imageType;
    }
}
