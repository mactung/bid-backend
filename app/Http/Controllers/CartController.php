<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepositoryInterface;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private $cartRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    } 

    public function getCartItems(Request $request, $token)
    {
        $retVal = self::RETVAL;
        
        if ($token) {
            $retVal['result'] = $this->cartRepository->getItems($token);
            if ($retVal['result']) {
                $retVal['status'] = self::SUCCESS_STATUS;
            }
        }
        return response()->json($retVal);
    }

    public function addItem(Request $request, $token)
    {
        $retVal = self::RETVAL;
        if ($token) {
            $token = $request->get('token');
            $productId = $request->get('product_id');
            $quantity = $request->get('quantity');
            $retVal['result'] = $this->cartRepository->addItem($token, $productId, $quantity);
            if ($retVal['result']) {
                $retVal['status'] = self::SUCCESS_STATUS;
            }
        }
        return response()->json($retVal);
    }

    public function create(Request $request)
    {
        $retVal = self::RETVAL;
        $token = Str::random(20);
        $retVal['status'] = self::SUCCESS_STATUS;
        $retVal['result'] = $this->cartRepository->create($token);
        return $retVal;
    }
}
