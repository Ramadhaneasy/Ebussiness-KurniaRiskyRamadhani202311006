<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Pastikan model Order ada
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard untuk user biasa (non-admin).
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Hitung total pesanan user yang login hari ini
        $ordersToday = Order::where('user_id', $user->id)
                            ->whereDate('created_at', Carbon::today())
                            ->count();
                            
        // 2. Hitung revenue user yang login hari ini
        $revenueToday = Order::where('user_id', $user->id)
                             ->whereDate('created_at', Carbon::today())
                             ->where('status', 'completed') // Asumsikan hanya status 'completed' yang dihitung
                             ->sum('total_price');

        // Mengirimkan data ke view
        return view('user.dashboard', [
            'ordersToday' => number_format($ordersToday),
            'revenueToday' => '$' . number_format($revenueToday, 0, '.', ','),
            // Tambahkan data lain yang relevan di sini
        ]);
    }
}