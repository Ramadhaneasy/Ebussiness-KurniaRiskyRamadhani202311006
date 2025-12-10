@extends('layouts.admin')

@section('content')
    {{-- Top statistic cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Today's Revenue</p>
                    <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                        Rp {{ number_format($todayRevenue / 1000000, 1) }}M
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $todayTransactions }} transactions</p>
                </div>
                <div class="flex flex-col items-end">
                    @if($revenueChange > 0)
                        <span class="text-xs text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                            +{{ number_format($revenueChange, 1) }}%
                        </span>
                    @elseif($revenueChange < 0)
                        <span class="text-xs text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">
                            {{ number_format($revenueChange, 1) }}%
                        </span>
                    @else
                        <span class="text-xs text-gray-600 bg-gray-50 dark:bg-gray-900/20 px-2 py-1 rounded-full">
                            0%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
            <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $totalCategories }} categories</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
            <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">{{ number_format($totalCustomers) }}</div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $newCustomersThisWeek }} new this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Low Stock Items</p>
            <div class="mt-2 text-xl font-bold {{ $lowStockItems > 0 ? 'text-orange-600 dark:text-orange-400' : 'text-gray-900 dark:text-white' }}">
                {{ $lowStockItems }}
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                {{ $lowStockItems > 0 ? 'Need restock soon' : 'All stocks good' }}
            </p>
        </div>
    </div>

    {{-- Sales analytics --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales Analytics</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Last 7 days performance</p>
            </div>
        </div>

        <div class="w-full h-64">
            <canvas id="sales-chart"></canvas>
        </div>

        <div class="mt-3 flex gap-4 text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Revenue
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span> Transactions
            </div>
        </div>
    </div>

    {{-- Lower grid: recent + top products --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Recent transactions --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-x-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                <a href="{{ route('admin.reports.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
            </div>

            @if($recentTransactions->count() > 0)
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-300 border-b dark:border-gray-700">
                            <th class="py-2">Order ID</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Product</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @foreach($recentTransactions as $transaction)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="py-3 font-medium text-gray-800 dark:text-gray-100">{{ $transaction->order_number }}</td>
                            <td class="py-3">{{ $transaction->user->name }}</td>
                            <td class="py-3">
                                @if($transaction->items->count() > 1)
                                    {{ $transaction->items->first()->product_name }} +{{ $transaction->items->count() - 1 }}
                                @else
                                    {{ $transaction->items->first()->product_name }}
                                @endif
                            </td>
                            <td class="py-3">Rp {{ number_format($transaction->total_amount / 1000, 0) }}K</td>
                            <td class="py-3">
                                @if($transaction->status === 'completed')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-8 text-gray-500">No transactions yet</div>
            @endif
        </div>

        {{-- Top Products --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Products</h3>
            </div>

            @if($topProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($topProducts as $index => $product)
                    <div class="flex items-center justify-between gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->product_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->total_sold }} sold</p>
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            Rp {{ number_format($product->total_revenue / 1000, 0) }}K
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">No sales data yet</div>
            @endif
        </div>
    </div>

    {{-- Bottom: quick actions + alerts --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Quick Actions</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('admin.users.create') }}" class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 transition text-center">
                    Add User
                </a>
                <a href="{{ route('admin.products.create') }}" class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 hover:bg-purple-100 transition text-center">
                    Add Product
                </a>
                <a href="{{ route('admin.reports.index') }}" class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 hover:bg-emerald-100 transition text-center">
                    View Reports
                </a>
                <a href="{{ route('admin.products.index') }}" class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 transition text-center">
                    Manage Products
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Alerts</h3>
            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                @if($lowStockItems > 0)
                    <div class="flex items-start gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-orange-400 mt-1"></div>
                        <div>
                            <p class="font-medium">{{ $lowStockItems }} Low stock items</p>
                            <a href="{{ route('admin.products.index') }}" class="text-xs text-blue-600 hover:underline">View products</a>
                        </div>
                    </div>
                @else
                    <div class="flex items-start gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-400 mt-1"></div>
                        <div>
                            <p class="font-medium">All stocks are good</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">No restock needed</p>
                        </div>
                    </div>
                @endif

                @if($todayTransactions > 0)
                    <div class="flex items-start gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-400 mt-1"></div>
                        <div>
                            <p class="font-medium">{{ $todayTransactions }} new orders today</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total: Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('sales-chart');
    const salesData = @json($salesData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Revenue (Rp)',
                data: salesData.map(d => d.revenue),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
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
                            return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush