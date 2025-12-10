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
        
        // Orders Today
        $ordersToday = $user->orders()
            ->whereDate('created_at', Carbon::today())
            ->count();
        
        // Revenue Today
        $revenueToday = $user->orders()
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');
        
        // Pending Orders
        $pendingOrders = $user->orders()
            ->where('status', 'pending')
            ->count();
        
        // Completed Orders
        $completedOrders = $user->orders()
            ->where('status', 'completed')
            ->count();
        
        // Recent Orders (last 5)
        $recentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'ordersToday',
            'revenueToday',
            'pendingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }
}