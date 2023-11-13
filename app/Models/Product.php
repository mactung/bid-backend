<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{
    protected $table = 'products';   
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specifics()
    {
        return $this->hasMany(Specific::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
