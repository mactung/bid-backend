<?php
namespace App\Repositories;

interface UserBidRepositoryInterface
{
    public function bid($userId, $productId, $price);
    public function getProductBids($productId);
}
