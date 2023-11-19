<?php

namespace App\Repositories;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\Specific;
use App\Models\User;
use DateTime;

class ProductRepository implements ProductRepositoryInterface
{
    public function getSellerProduct($sellerId, $perPage, $pageIndex)
    {
        return Product::where('user_id', $sellerId)
            ->paginate($perPage);
    }

    public function storeProduct($product, $galleries, $specifics)
    {
        $product = Product::create($product);
        $insertDataGalleries = [];
        foreach ($galleries as $gallery) {
            $insertDataGalleries[] = [
                'product_id' => $product->id,
                'image_url' => $gallery['image_url'],
                'created_at' => new DateTime(), 'updated_at' => new DateTime()
            ];
        }
        Gallery::insert($insertDataGalleries);
        $insertDataSpecifics = [];
        foreach ($specifics as $specific) {
            $insertDataSpecifics[] = [
                'label' => $specific['label'],
                'value' => $specific['value'],
                'product_id' => $product->id
            ];
        }
        Specific::insert($insertDataSpecifics);
        return $product;
    }

    public function updateProduct($product, $galleries, $specifics)
    {
        Product::find($product['id'])->update($product);
        $insertDataGalleries = [];
        $existIds = [];
        foreach ($galleries as $gallery) {
            if (isset($gallery->id)) {
                $existIds[] = $gallery->id;
            } else {
                $insertDataGalleries[] = [
                    'product_id' => $product['id'],
                    'image_url' => $gallery['image_url'],
                    'created_at' => new DateTime(), 'updated_at' => new DateTime()
                ];
            }
        }
        Gallery::whereNotIn('id', $existIds)
                ->where('product_id', $product['id'])   
                ->delete();
        Gallery::insert($insertDataGalleries);
        
        $insertDataSpecifics = [];
        $existsIds = [];
        foreach ($specifics as $specific) {
            if (isset($specific->id)) {
                $existsIds[] = $specific->id;
            } else {
                $insertDataSpecifics[] = [
                    'label' => $specific['label'],
                    'value' => $specific['value'],
                    'product_id' => $product['id'],
                    'created_at' => new DateTime(), 'updated_at' => new DateTime()
                ];
            }
        }
        Specific::whereNotIn('id', $existsIds)
            ->where('product_id', $product['id'])
            ->delete();
        Specific::insert($insertDataSpecifics);
        
        return $product;
    }

    

    public function destroyProduct($productId)
    {
        $isDestroy = Product::find($productId)
            ->update(['deleted_at' => new DateTime()]);
        return $isDestroy;
    }
}
