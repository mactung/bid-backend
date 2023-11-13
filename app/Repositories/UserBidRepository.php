<?php
namespace App\Repositories;

use App\Models\UserBid;

class UserBidRepository implements UserBidRepositoryInterface
{
    public function bid($userId, $productId, $price)
    {
        return UserBid::create([
            'user_id' => $userId, 
            'product_id' => $productId,
            'price' => $price
        ]);
    }

    public function getProductBids($productId)
    {
        return UserBid::with('user')
            ->where('product_id', $productId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
    }
}