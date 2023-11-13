<?php

namespace App\Http\Controllers;

use App\Models\Product;
// use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserBidRepositoryInterface;

use Illuminate\Http\Request;
use Validator;
use GuzzleHttp\Client;

class BidController extends Controller
{

    private $userBidRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserBidRepositoryInterface $userBidRepository)
    {
        $this->userBidRepository = $userBidRepository;
    }

    //

    public function bid(Request $request, $productId)
    {
        $retVal = self::RETVAL;
        $validator = Validator::make($request->all(), [
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $websocketServerUrl = 'http://localhost:3001/update-price/' . $productId;

        // Create a WebSocket message


        if ($validator->validated()) {
            $product = Product::find($productId);
            $bibPrice = $request->get('price');
            if ($product->price < $bibPrice) {
                $product->price  = $bibPrice;
                $user = Auth()->user();
                $this->userBidRepository->bid($user->id, $product->id, $bibPrice);
                if ($product->save()) {
                    $message = [
                        'action' => 'updatePrice',
                        'productId' => $productId,
                        'newPrice' => $bibPrice,
                        'user' => $user,
                    ];
            
                    // Send the message to the WebSocket server
                    $client = new Client();
                    $client->post($websocketServerUrl, [
                        'json' => $message,
                    ]);
                    $retVal['status'] = self::SUCCESS_STATUS;
                    $retVal['message'] = 'Đấu giá thành công';
                };
            } else {
                $retVal['status'] = self::SUCCESS_STATUS;
                $retVal['message'] = 'Không thể đấu giá! Vì giá hiện tại đang là: ' . $product->price;
            }
        }
        return $retVal;
    }
}
