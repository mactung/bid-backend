<?php

namespace App\Http\Controllers;
use App\Repositories\UserBidRepositoryInterface;
use Illuminate\Http\Request;

class UserBidController extends Controller
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

    public function getBids(Request $request, $productId)
    {
        $retVal = self::RETVAL;
        $bids = $this->userBidRepository->getProductBids($productId);
        if (count($bids)) {
            $retVal['result'] = $bids;
        }
        return $retVal;
    }

    //
}
