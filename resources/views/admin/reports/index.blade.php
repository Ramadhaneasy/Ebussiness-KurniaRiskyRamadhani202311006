@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reports & Analytics</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Comprehensive business insights and data</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        Rp {{ number_format($totalRevenue / 1000000, 1) }}M
                    </p>
                    <p class="text-xs text-gray-500 mt-1">All time</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalOrders) }}</p>
                    @if($revenueChange > 0)
                        <p class="text-xs text-green-600 mt-1">+{{ number_format($revenueChange, 1) }}% this month</p>
                    @elseif($revenueChange < 0)
                        <p class="text-xs text-red-600 mt-1">{{ number_format($revenueChange, 1) }}% this month</p>
                    @else
                        <p class="text-xs text-gray-500 mt-1">0% change</p>
                    @endif
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Avg Order Value</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                        Rp {{ number_format($averageOrderValue / 1000, 0) }}K
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Per transaction</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">New Customers</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $newCustomersThisMonth }}</p>
                    <p class="text-xs text-gray-500 mt-1">This month</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Revenue Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Revenue Trend</h3>
        <div class="w-full h-64">
            <canvas id="monthly-chart"></canvas>
        </div>
    </div>

    {{-- Detailed Reports --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sales Report</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Sales</span>
                    <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Orders</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($totalOrders) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Average Order Value</span>
                    <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Completed Orders</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($completedOrders) }} ({{ number_format($completedPercentage, 1) }}%)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Pending Orders</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($pendingOrders) }} ({{ number_format($pendingPercentage, 1) }}%)</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Customer Report</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Customers</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($totalCustomers) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">New This Month</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($newCustomersThisMonth) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Active Users</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($activeCustomers) }} ({{ number_format($activePercentage, 1) }}%)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Returning Customers</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($returningCustomers) }} ({{ number_format($returningPercentage, 1) }}%)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Customer Retention</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($retentionRate, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Customers --}}
    @if($topCustomers->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Customers</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-300 border-b dark:border-gray-700">
                        <th class="py-3">Rank</th>
                        <th class="py-3">Customer</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Total Orders</th>
                        <th class="py-3">Total Spent</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @foreach($topCustomers as $index => $customer)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="py-3 font-bold">{{ $index + 1 }}</td>
                        <td class="py-3">{{ $customer->user->name }}</td>
                        <td class="py-3">{{ $customer->user->email }}</td>
                        <td class="py-3">{{ $customer->total_orders }}</td>
                        <td class="py-3 font-semibold">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- All Orders Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">All Orders</h3>
        
        @if($allOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-300 border-b dark:border-gray-700">
                            <th class="py-3">Order Number</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Items</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @foreach($allOrders as $order)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="py-3 font-medium">{{ $order->order_number }}</td>
                            <td class="py-3">{{ $order->user->name }}</td>
                            <td class="py-3">{{ $order->items->count() }} item(s)</td>
                            <td class="py-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3">
                                @if($order->status === 'completed')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                                @endif
                            </td>
                            <td class="py-3">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $allOrders->links() }}
            </div>
        @else
            <div class="text-center py-8 text-gray-500">No orders yet</div>
        @endif
    </div>

    {{-- Export Section --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Export Reports</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Download your reports in various formats</p>
        <div class="flex flex-wrap gap-3">
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition flex items-center gap-2" onclick="alert('Excel export feature coming soon!')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export to Excel
            </button>
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition flex items-center gap-2" onclick="window.print()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthly-chart');
    const monthlyData = @json($monthlyRevenue);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [{
                label: 'Revenue (Rp)',
                data: monthlyData.map(d => d.revenue),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: '#3B82F6',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush