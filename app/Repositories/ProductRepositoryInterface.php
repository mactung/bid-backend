<?php
// app/Repositories/UserRepositoryInterface.php
namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getSellerProduct($sellerId, $perPage, $pageIndex);
    public function storeProduct($product, $galleries, $specifics);
    public function updateProduct($product, $galleries, $specifics);
    public function destroyProduct($productId);
}
