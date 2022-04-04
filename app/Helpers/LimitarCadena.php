<?php
namespace App\Helpers;

use App\Models\Service;

use Illuminate\Support\Facades\DB;

class LimitarCadena {

    public static function limitar($cadena, $limite, $sufijo) {
        
        if(strlen($cadena) > $limite){
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limite) . $sufijo;
        }
        
        // Si no, entonces devuelve la cadena normal
        return $cadena;
    }
}
