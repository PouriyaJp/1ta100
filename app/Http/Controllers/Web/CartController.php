<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', new Cart());
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // بررسی اینکه آیا سبد خرید در session وجود دارد یا نه
        $cart = session()->get('cart');
        if (!$cart) {
            // ایجاد سبد خرید جدید در صورت عدم وجود
            $cart = new Cart();
            $cart->price = 0;
            $cart->status = 1;
            $cart->save();
            session()->put('cart', $cart);
        }

        // بررسی وجود آیتم در سبد خرید
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            return redirect()->back()->with('error', 'Product already in cart');
        }

        // اضافه کردن محصول به سبد خرید
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]);

        // به‌روزرسانی قیمت کل سبد خرید
        $cart->price = $cart->total_price; // محاسبه قیمت کل
        $cart->save();

        // به‌روزرسانی session با سبد خرید جدید
        session()->put('cart', $cart);
        return redirect()->route('cart.index');
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

        // حذف سبد خرید اگر هیچ محصولی در آن نیست
        if ($cart->items()->count() == 0) {
            $cart->delete();
            session()->forget('cart');
            return redirect()->route('cart.index')->with('message', 'Cart is empty and has been deleted');
        }

        session()->put('cart', $cart);
        return new CartResource($cart->load('items.product'));
    }
}
