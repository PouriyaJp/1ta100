<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartPrice = \intval($product['price']) * $request['quantity'];

        // ایجاد یا پیدا کردن سبد خرید
        $cart = null;
        if ($request->has('cart_id')) {
            $cart = Cart::findOrFail($request->cart_id);
        } else {
            $cart = Cart::create([
                'price' => $cartPrice,
                'status' => 1
            ]);
        }


        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            return response()->json(['message' => 'Product already in cart'], 400);
        }

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]);

        return new CartResource($cart->load('items.product'));
    }

    public function removeFromCart(Request $request, Product $product)
    {

        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Product not in cart'], 400);
        }

        $cartItem->delete();

        // اگر سبد خرید خالی شد، آن را حذف کن
        if ($cart->items()->count() == 0) {
            $cart->delete();
            return response()->json(['message' => 'Cart is empty and has been deleted'], 200);
        }

        return new CartResource($cart->load('items.product'));
    }

    public function viewCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::findOrFail($request->cart_id)->load('items.product');

        return new CartResource($cart);
    }

}
