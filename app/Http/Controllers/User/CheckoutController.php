<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Halaman checkout
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        return view('user.checkout.index', compact('carts', 'total'));
    }

    // Process checkout
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500'
        ]);

        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        // Cek stock semua produk
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', "Stock not available for {$cart->product->name}!");
            }
        }

        DB::beginTransaction();

        try {
            // Hitung total
            $total = $carts->sum(function ($cart) {
                return $cart->quantity * $cart->product->price;
            });

            // Buat order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => 'COD',
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes
            ]);

            // Buat order items & kurangi stock
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'product_name' => $cart->product->name,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'subtotal' => $cart->quantity * $cart->product->price
                ]);

                // Kurangi stock
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Hapus cart
            auth()->user()->carts()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order. Please try again.');
        }
    }

    // Daftar orders user
    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    // Detail order
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('user.orders.show', compact('order'));
    }
}