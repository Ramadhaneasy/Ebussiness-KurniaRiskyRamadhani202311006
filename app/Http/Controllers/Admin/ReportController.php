<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Total Revenue (All Time)
        $totalRevenue = Order::sum('total_amount');
        
        // Total Orders
        $totalOrders = Order::count();
        
        // Average Order Value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        // Revenue This Month
        $revenueThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');
        
        // Orders This Month
        $ordersThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Calculate percentage change from last month
        $revenueLastMonth = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_amount');
        
        $revenueChange = 0;
        if ($revenueLastMonth > 0) {
            $revenueChange = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
        } elseif ($revenueThisMonth > 0) {
            $revenueChange = 100;
        }
        
        // Sales Report Details
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedPercentage = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
        $pendingPercentage = $totalOrders > 0 ? ($pendingOrders / $totalOrders) * 100 : 0;
        
        // Customer Report
        $totalCustomers = User::where('role', 'user')->count();
        $newCustomersThisMonth = User::where('role', 'user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        $activeCustomers = User::where('role', 'user')
            ->whereHas('orders')
            ->count();
        
        $returningCustomers = User::where('role', 'user')
            ->whereHas('orders', function($query) {
                $query->select('user_id')
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->count();
        
        $activePercentage = $totalCustomers > 0 ? ($activeCustomers / $totalCustomers) * 100 : 0;
        $returningPercentage = $totalCustomers > 0 ? ($returningCustomers / $totalCustomers) * 100 : 0;
        $retentionRate = $activeCustomers > 0 ? ($returningCustomers / $activeCustomers) * 100 : 0;
        
        // Monthly Revenue Chart (Last 6 months)
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Order::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            
            $monthlyRevenue->push([
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ]);
        }
        
        // Top Customers (by total spending)
        $topCustomers = Order::select('user_id')
            ->selectRaw('SUM(total_amount) as total_spent')
            ->selectRaw('COUNT(*) as total_orders')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();
        
        // All Orders for detailed table
        $allOrders = Order::with('user', 'items')
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', [
            'active' => 'reports',
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'averageOrderValue' => $averageOrderValue,
            'revenueThisMonth' => $revenueThisMonth,
            'ordersThisMonth' => $ordersThisMonth,
            'revenueChange' => $revenueChange,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'completedPercentage' => $completedPercentage,
            'pendingPercentage' => $pendingPercentage,
            'totalCustomers' => $totalCustomers,
            'newCustomersThisMonth' => $newCustomersThisMonth,
            'activeCustomers' => $activeCustomers,
            'returningCustomers' => $returningCustomers,
            'activePercentage' => $activePercentage,
            'returningPercentage' => $returningPercentage,
            'retentionRate' => $retentionRate,
            'monthlyRevenue' => $monthlyRevenue,
            'topCustomers' => $topCustomers,
            'allOrders' => $allOrders
        ]);
    }
}