<?php
// app/Repositories/UserRepositoryInterface.php
namespace App\Repositories;

interface CartRepositoryInterface
{
    public function getItems($token);
    public function addItem($cartId, $productId, $quantity);
    public function create($token);
}
