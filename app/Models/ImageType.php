<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageType extends Model
{
    protected $table = 'image_type';

    protected $fillable = [
        'image_type',
        'image_type_code',
    ];
}
