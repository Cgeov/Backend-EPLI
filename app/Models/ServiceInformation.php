<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceInformation extends Model
{
    protected $table = 'service_informations';

    protected $fillable = [
        'title',
        'description',
        'main_picture',
        'link',
        'document_name',
        'service_id',
        'principal',
    ];

    //RELACION MANY TO ONE / DE MUCHOS A UNO
    public function services(){
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
