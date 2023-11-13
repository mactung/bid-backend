<?php
// app/Repositories/UserRepositoryInterface.php
namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getSellerProduct($sellerId, $perPage, $pageIndex);
}
