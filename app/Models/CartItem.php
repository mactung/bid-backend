<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model 
{
    protected $table = 'cart_item';   
    protected $fillable = ['cart_id', 'product_id'];

    public function product ()
    {
        return $this->belongsTo(Product::class);
    }
}
