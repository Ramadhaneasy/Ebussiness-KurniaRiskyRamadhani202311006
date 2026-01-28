<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Recent Orders (ambil lebih banyak untuk dashboard)
        $recentOrders = $user->orders()
            ->with(['items', 'payment'])
            ->latest()
            ->take(6)
            ->get();

        // Order yang ditrack (ambil yang paling baru)
        $trackedOrder = $recentOrders->first();

        // tentukan step tracking
        $trackingStep = 'payment_pending';
        if ($trackedOrder) {
            $status = strtolower($trackedOrder->status ?? 'pending');

            // mapping fleksibel (kalau nanti kamu tambah status processing/shipped)
            if (in_array($status, ['completed', 'delivered', 'done'])) {
                $trackingStep = 'completed';
            } elseif (in_array($status, ['shipped', 'shipping'])) {
                $trackingStep = 'shipped';
            } elseif (in_array($status, ['processing', 'packaging', 'prepared'])) {
                $trackingStep = 'packaging';
            } else {
                // pending
                $trackingStep = 'payment_pending';
            }
        }

        return view('user.dashboard', compact('recentOrders', 'trackedOrder', 'trackingStep'));
    }
}
