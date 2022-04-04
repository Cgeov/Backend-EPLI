<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailServiceInformation extends Model
{
    protected $table = 'workshop_course_detail';

    //ESTOS SON LOS CAMPOS DE LA TABLA USERS
    //OSEA, QUE AQUI AGREGO LOS CAMPOS DE LA TABLA :v
    protected $fillable = [
        'workshop_course',
        'detail',
    ];

    //RELACION MANY TO ONE / DE MUCHOS A UNO
    public function service_informations(){
        return $this->belongsTo('App\Models\ServiceInformation', 'detail');
    }
}
