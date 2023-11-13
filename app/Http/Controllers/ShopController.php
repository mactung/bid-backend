<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepositoryInterface;

class ShopController extends Controller
{
    private $productRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getShopProducts ($sellerId)
    {
        $retVal = self::RETVAL;
        $retVal['result'] = $this->productRepository->getSellerProduct($sellerId, 40, 0)->items();
        $retVal['status'] = self::SUCCESS_STATUS;
        return response()->json($retVal);
    }

    //
}
