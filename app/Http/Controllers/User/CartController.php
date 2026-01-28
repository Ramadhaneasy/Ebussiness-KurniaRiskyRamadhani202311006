<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function assertOwner(Cart $cart): void
    {
        abort_if($cart->user_id !== auth()->id(), 403);
    }

    // Tampilkan cart
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        $total = $carts->sum(fn ($cart) => $cart->quantity * $cart->product->price);

        return view('user.cart.index', compact('carts', 'total'));
    }

    // Add to cart
    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock not available!');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stock not available!');
            }

            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    // Update quantity
    public function update(Cart $cart, Request $request)
    {
        $this->assertOwner($cart);

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->loadMissing('product');

        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'Stock not available!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    // Remove from cart
    public function remove(Cart $cart)
    {
        $this->assertOwner($cart);

        $cart->delete();
        return back()->with('success', 'Product removed from cart!');
    }
}
