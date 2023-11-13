<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\User;

class ProductRepository implements ProductRepositoryInterface
{
    public function getSellerProduct($sellerId, $perPage, $pageIndex)
    {   
        return Product::where('user_id', $sellerId)
            ->paginate($perPage);
    }
}