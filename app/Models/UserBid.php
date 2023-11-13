<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBid extends Model 
{
    protected $table = 'user_bid';   
    protected $fillable = ['user_id', 'product_id', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
