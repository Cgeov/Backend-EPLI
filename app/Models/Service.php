<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //AQUI PONEMOS EL NOMBRE DE LA TABLA A LA QUE 
    //ACCEDEREMOS EN LA BASE DE DATOS
    //ESTO POR SI A LA TABLA SERVICES
    //LE HUBIERA PUESTO SERVICES_"x" O ALGUN OTRO NOMBRE
    protected $table = 'services';

    //ESTOS SON LOS CAMPOS DE LA TABLA USERS
    //OSEA, QUE AQUI AGREGO LOS CAMPOS DE LA TABLA :v
    protected $fillable = [
        'service_name',
        'service_code',
        'service_icon',
        'slider',
        'link',
        'document',
        'details',
    ];

    //RELACION ONE TO MANY
    public function service_options(){
        return $this->hasMany('App\Models\ServiceOption');
    }

    //RELACION ONE TO MANY
    public function service_informations(){
        return $this->hasMany('App\Models\ServiceInformation');
    }
}
