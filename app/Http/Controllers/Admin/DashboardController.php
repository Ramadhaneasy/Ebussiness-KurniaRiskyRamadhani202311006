<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's Revenue
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->sum('total_amount');
        
        // Today's Transactions Count
        $todayTransactions = Order::whereDate('created_at', Carbon::today())
            ->count();
        
        // Calculate percentage change from yesterday
        $yesterdayRevenue = Order::whereDate('created_at', Carbon::yesterday())
            ->sum('total_amount');
        
        $revenueChange = 0;
        if ($yesterdayRevenue > 0) {
            $revenueChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
        } elseif ($todayRevenue > 0) {
            $revenueChange = 100;
        }
        
        // Total Products
        $totalProducts = Product::count();
        $totalCategories = Product::distinct('category')->count('category');
        
        // Total Customers
        $totalCustomers = User::where('role', 'user')->count();
        $newCustomersThisWeek = User::where('role', 'user')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->count();
        
        // Low Stock Items (stock < 25)
        $lowStockItems = Product::where('stock', '<', 25)->count();
        
        // Sales Analytics (Last 7 days)
        $salesData = Order::whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Fill missing dates with 0
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $data = $salesData->firstWhere('date', $date);
            
            $last7Days->push([
                'date' => Carbon::parse($date)->format('D'),
                'revenue' => $data ? $data->revenue : 0,
                'transactions' => $data ? $data->transactions : 0
            ]);
        }
        
        // Recent Transactions (Last 10)
        $recentTransactions = Order::with('user', 'items')
            ->latest()
            ->take(10)
            ->get();
        
        // Top Products (by quantity sold)
        $topProducts = OrderItem::select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_sold')
            ->selectRaw('SUM(subtotal) as total_revenue')
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'active' => 'dashboard',
            'todayRevenue' => $todayRevenue,
            'todayTransactions' => $todayTransactions,
            'revenueChange' => $revenueChange,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalCustomers' => $totalCustomers,
            'newCustomersThisWeek' => $newCustomersThisWeek,
            'lowStockItems' => $lowStockItems,
            'salesData' => $last7Days,
            'recentTransactions' => $recentTransactions,
            'topProducts' => $topProducts
        ]);
    }
}