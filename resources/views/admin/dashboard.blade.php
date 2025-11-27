@extends('layouts.admin')

@section('content')
    {{-- Top statistic cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Today's Revenue</p>
                    <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">Rp 4.2M</div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">42 transactions</p>
                </div>
                <span class="text-xs text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+15.3%</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
            <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">1,248</div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">125 categories</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
            <div class="mt-2 text-xl font-bold text-gray-900 dark:text-white">8,462</div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">234 new this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">Low Stock Items</p>
            <div class="mt-2 text-xl font-bold text-orange-600 dark:text-orange-400">24</div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Need restock soon</p>
        </div>
    </div>

    {{-- Sales analytics chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales Analytics</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Last 7 days performance</p>
            </div>

            <div class="flex items-center gap-3">
                <button data-range="7" class="range-btn px-3 py-1 text-sm rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-600">7 Days</button>
                <button data-range="30" class="range-btn px-3 py-1 text-sm rounded-md text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">30 Days</button>
                <button data-range="90" class="range-btn px-3 py-1 text-sm rounded-md text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition">90 Days</button>
            </div>
        </div>

        <div class="w-full h-64">
            <svg id="sales-chart" class="w-full h-full" viewBox="0 0 800 200" preserveAspectRatio="none"></svg>
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

    {{-- Recent transactions + Top products --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Recent Transactions --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-x-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
            </div>

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
                    @php
                        $recent = [
                            ['id' => '#INV-2847','name'=>'John Doe','product'=>'Wireless Earbuds','amount'=>'Rp 850K','status'=>'Completed'],
                            ['id' => '#INV-2846','name'=>'Jane Smith','product'=>'Smart Watch','amount'=>'Rp 1.2M','status'=>'Pending'],
                            ['id' => '#INV-2845','name'=>'Mike Johnson','product'=>'USB-C Cable','amount'=>'Rp 45K','status'=>'Completed'],
                            ['id' => '#INV-2844','name'=>'Sarah Williams','product'=>'Phone Case','amount'=>'Rp 120K','status'=>'Processing'],
                        ];
                    @endphp

                    @foreach($recent as $r)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="py-3 font-medium text-gray-800 dark:text-gray-100">{{ $r['id'] }}</td>
                        <td class="py-3">{{ $r['name'] }}</td>
                        <td class="py-3">{{ $r['product'] }}</td>
                        <td class="py-3">{{ $r['amount'] }}</td>
                        <td class="py-3">
                            @if($r['status'] === 'Completed')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span>
                            @elseif($r['status'] === 'Pending')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">{{ $r['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Top Products --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Products</h3>
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all</a>
            </div>

            @php
                $products = [
                    ['name'=>'Wireless Earbuds','sold'=>342,'price'=>'Rp 850K'],
                    ['name'=>'Smart Watch','sold'=>298,'price'=>'Rp 1.2M'],
                    ['name'=>'USB-C Cable','sold'=>256,'price'=>'Rp 45K'],
                    ['name'=>'Phone Case','sold'=>189,'price'=>'Rp 120K'],
                ];
            @endphp

            <div class="space-y-3">
                @foreach($products as $i => $p)
                <div class="flex items-center justify-between gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold">{{ $i+1 }}</div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $p['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $p['sold'] }} sold</p>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $p['price'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick Actions + Alerts --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Quick Actions</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <button class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 transition">Add User</button>
                <button class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 hover:bg-purple-100 transition">New Invoice</button>
                <button class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 hover:bg-emerald-100 transition">View Reports</button>
                <button class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 hover:bg-gray-100 transition">Settings</button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Alerts</h3>
            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <div class="flex items-start gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-orange-400 mt-1"></div>
                    <div>
                        <p class="font-medium">Low stock: USB-C Cable</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">24 left — reorder soon</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 mt-1"></div>
                    <div>
                        <p class="font-medium">Payment gateway maintenance</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Scheduled at 02:00 AM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endpush