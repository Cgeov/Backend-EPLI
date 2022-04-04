<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'image_name',
        'type_image',
    ];

    //RELACION MANY TO ONE / DE MUCHOS A UNO
    public function type_image(){
        return $this->belongsTo('App\Models\ImageType', 'type_image');
    }
}
