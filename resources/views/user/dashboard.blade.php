<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Welcome Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Welcome back, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Here's an overview of your activity today.
                    </p>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Orders Today</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $ordersToday }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Revenue Today</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Orders</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">5</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">142</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                    <th class="py-3">Order ID</th>
                                    <th class="py-3">Product</th>
                                    <th class="py-3">Amount</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 dark:text-gray-300">
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="py-3 font-medium">#ORD-001</td>
                                    <td class="py-3">Wireless Earbuds</td>
                                    <td class="py-3">Rp 850,000</td>
                                    <td class="py-3"><span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Completed</span></td>
                                    <td class="py-3">Today</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="py-3 font-medium">#ORD-002</td>
                                    <td class="py-3">Smart Watch</td>
                                    <td class="py-3">Rp 1,200,000</td>
                                    <td class="py-3"><span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span></td>
                                    <td class="py-3">Today</td>
                                </tr>
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="py-3 font-medium">#ORD-003</td>
                                    <td class="py-3">USB-C Cable</td>
                                    <td class="py-3">Rp 45,000</td>
                                    <td class="py-3"><span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Processing</span></td>
                                    <td class="py-3">Today</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>