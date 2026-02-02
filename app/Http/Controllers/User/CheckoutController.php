<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NewOrderNotification;


class CheckoutController extends Controller
{
    // Halaman checkout
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $total = $carts->sum(fn ($cart) => $cart->quantity * $cart->product->price);

        return view('user.checkout.index', compact('carts', 'total'));
    }

    // Process checkout
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:COD,BANK_TRANSFER',
        ]);

        $carts = auth()->user()->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', "Stock not available for {$cart->product->name}!");
            }
        }

        DB::beginTransaction();

        try {
            $total = $carts->sum(fn ($cart) => $cart->quantity * $cart->product->price);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'product_name' => $cart->product->name,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'subtotal' => $cart->quantity * $cart->product->price
                ]);

                $cart->product->decrement('stock', $cart->quantity);
            }

            // Create payment record (NEW)
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => 'pending',
                'amount' => $total,
            ]);

            // Hapus cart
            auth()->user()->carts()->delete();

            DB::commit();

            // Kirim notifikasi ke semua admin
$admins = User::where('role', 'admin')->get();
foreach ($admins as $admin) {
    $admin->notify(new NewOrderNotification($order->load('user')));
}


            // Redirect tergantung metode
            if ($request->payment_method === 'BANK_TRANSFER') {
                return redirect()->route('payment.show', $order->id)
                    ->with('success', 'Order created! Please complete your payment.');
            }

            return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order. Please try again.');
        }
    }

    // Daftar orders user
    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product', 'payment')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    // Detail order
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product', 'payment');
        return view('user.orders.show', compact('order'));
    }
}
