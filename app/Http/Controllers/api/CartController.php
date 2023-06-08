<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;


class CartController extends Controller
{
    public function addProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Add the product to the cart with a quantity of 1
        $cart->products()->attach($product->id, ['quantity' => 1]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    private function getCart()
    {
        $user = User::findOrFail(auth()->user()->id);
        return $user->cart()->firstOrCreate([]);
    }

    public function updateQuantity(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Update the quantity of the product in the cart
        $cart->products()->syncWithoutDetaching([$product->id => ['quantity' => $request->input('quantity')]]);

        return response()->json(['message' => 'Product quantity updated successfully']);
    }

    public function removeProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        // Remove the product from the cart
        $cart->products()->detach($product->id);

        // Check if the cart is empty and delete it if so
        if ($cart->products()->count() === 0) {
            $cart->delete();
        }

        return response()->json(['message' => 'Product removed from cart successfully']);
    }


    public function createOrder(Request $request)
    {
        $cart = $this->getCart();
        $products = $cart->products()->pluck('id')->toArray();

        if (empty($products)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $order = $this->storeOrder(auth()->user()->id, $products);

        // Clear the cart after creating the order
        $cart->products()->detach();
        $cart->delete();

        return new OrderResource($order);
    }

    private function storeOrder($userId, $productIds)
    {
        $order = Order::create([
            'user_id' => $userId
        ]);

        $order->products()->attach($productIds);

        return $order;
    }

    public function getCartProducts()
    {
        $cart = $this->getCart();
        $products = $cart->products;

        return response()->json(['products' => $products]);
    }
}
