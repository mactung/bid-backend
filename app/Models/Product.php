<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Product extends Model 
{
    static $rules = [
    ];
    protected $table = 'products';   
    protected $fillable = ['name', 'price', 'bid_price_step', 'bid_end_time', 'image_url', 'brand_id',
        'description', 'slug', 'buy_now_price', 'user_id'];
    
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

    protected static function boot() {
        parent::boot();
    
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
