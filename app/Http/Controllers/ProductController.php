<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use DateTime;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;

    const MODEL = "App\Models\Product";

	use RESTActions;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

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
            $productData = $request->all();
            $productData['user_id'] = $user->id;
            $galleries = $request->get('galleries');
            $specifics = $request->get('specifics');
            $product = $this->productRepository->storeProduct($productData, $galleries, $specifics);
            $retVal['result'] = $product;
            $retVal['status'] = self::SUCCESS_STATUS;
        }
        
		return $this->respond('created',  $retVal);
	}

    public function updateProduct(Request $request, $id)
    {
        $m = self::MODEL;
		$this->validate($request, $m::$rules);
        $user = Auth()->user();
        $retVal = self::RETVAL;
        $productData = $request->all();

        if ($user && $id && $user->id === $productData['user_id']) {
            $productData['user_id'] = $user->id;
            $productData['id'] = $id;
            $galleries = $request->get('galleries');
            $specifics = $request->get('specifics');
            $product = $this->productRepository->updateProduct($productData, $galleries, $specifics);
            $retVal['result'] = $product;
            $retVal['status'] = self::SUCCESS_STATUS;
        }
        
		return $this->respond('created',  $retVal);
    }

    public function destroyProduct($id)
    {
        $isDestroy = $this->productRepository->destroyProduct($id);
        $retVal = self::RETVAL;
        if ($isDestroy) {
            $retVal['result'] = $isDestroy;
            $retVal['status'] = self::SUCCESS_STATUS;
        }
        return response()->json($retVal);
    }

}
