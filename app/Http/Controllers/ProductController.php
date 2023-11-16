<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const MODEL = "App\Models\Product";

	use RESTActions;

    public function getAll(Request $request)
    {
        $retVal = self::RETVAL;
        $seller = Auth()->user();
        if ($seller) {
            $query = Product::where('user_id', $seller->id)
                ->orderBy('id', 'desc')
                ->paginate(15);
            $retVal['result'] = $query->items();
            $retVal['meta'] = [
				'page_index' => $query->currentPage(),
				'total_pages' => $query->lastPage(),
				'total_count' => $query->total(),
				'page_size' => $query->perPage(),
			];
            $retVal['status'] = self::SUCCESS_STATUS;
        }
        return response()->json($retVal);
    }

    public function addProduct(Request $request)
	{
		$m = self::MODEL;
		$this->validate($request, $m::$rules);
        $user = Auth()->user();
        $retVal = self::RETVAL;
        if ($user) {
            $product = $m::create($request->all());
            $product->user_id = $user->id;
            $product->save();
            $galleries = $request->get('galleries');
            $insertDataGalleries = [];
            foreach ($galleries as $gallery) {
                $insertDataGalleries[] = ['product_id' => $product->id, 'image_url' => $gallery, 
                    'created_at' => new DateTime(), 'updated_at' => new DateTime()
                    ] ;
            }
            Gallery::insert($insertDataGalleries);
            $retVal['result'] = $product;
            $retVal['status'] = self::SUCCESS_STATUS;
        }
        
		return $this->respond('created',  $retVal);
	}

}
