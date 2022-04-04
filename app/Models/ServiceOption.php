<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    //AQUI PONEMOS EL NOMBRE DE LA TABLA A LA QUE 
    //ACCEDEREMOS EN LA BASE DE DATOS
    //ESTO POR SI A LA TABLA SERVICE_OPTIONS
    //LE HUBIERA PUESTO OPTIONS O ALGUN OTRO NOMBRE
    protected $table = 'service_options';

    //ESTOS SON LOS CAMPOS DE LA TABLA USERS
    //OSEA, QUE AQUI AGREGO LOS CAMPOS DE LA TABLA :v
    protected $fillable = [
        'service_option_name',
        'service_option_code',
        'service_id',
        'action',
    ];

    //RELACION MANY TO ONE / DE MUCHOS A UNO
    public function services(){
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
