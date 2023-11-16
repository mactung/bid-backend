<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository implements CartRepositoryInterface
{
    public function getItems($token)
    {
        $cart = Cart::where('token', $token)->first();
        if ($cart) {
            return CartItem::where('cart_id', $cart->id)
                ->join('products', 'products.id', 'cart_item.product_id')
                ->select('product_id', 'name', 'quantity', 'price')
                ->get();
        }
        return null;
    }

    public function addItem($token, $productId, $quantity = 1)
    {
        $cart = Cart::where('token', $token)->first();
        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => 1
        ]);
    }

    public function create($token)
    {
        return Cart::create([
            'token' => $token,
        ]);
    }
}
