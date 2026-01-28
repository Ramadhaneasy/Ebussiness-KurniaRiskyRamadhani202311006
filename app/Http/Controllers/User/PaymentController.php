<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('payment');

        // Kalau order bukan transfer, redirect aja
        if ($order->payment_method !== 'BANK_TRANSFER') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'This order does not require bank transfer payment.');
        }

        // Pastikan payment ada
        if (!$order->payment) {
            $order->payment()->create([
                'method' => 'BANK_TRANSFER',
                'status' => 'pending',
                'amount' => $order->total_amount,
            ]);

            $order->load('payment');
        }

        return view('user.payment.show', [
            'order' => $order,
            'payment' => $order->payment,
        ]);
    }

    public function uploadProof(Order $order, Request $request)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('payment');

        if ($order->payment_method !== 'BANK_TRANSFER') {
            return back()->with('error', 'This order does not require bank transfer payment.');
        }

        $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $payment = $order->payment ?? $order->payment()->create([
            'method' => 'BANK_TRANSFER',
            'status' => 'pending',
            'amount' => $order->total_amount,
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        $payment->update([
            'proof_path' => $path,
            'submitted_at' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Proof uploaded! Waiting for confirmation.');
    }
}
