<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model 
{
    protected $table = 'galleries';   
    protected $fillable = ['product_id', 'image_url'];
}
