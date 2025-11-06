<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white tracking-tight">
            Dashboard Khusus Ngadimin Rrmadhan
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Users -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-slate-800 shadow hover:shadow-xl border border-slate-200 dark:border-slate-700 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full">+12%</span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Users</h3>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white">124</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Active members</p>
                </div>

                <!-- New Orders -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-slate-800 shadow hover:shadow-xl border border-slate-200 dark:border-slate-700 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl shadow text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full">+8%</span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">New Orders</h3>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white">32</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Pending orders</p>
                </div>

                <!-- Revenue -->
                <div class="relative p-6 rounded-2xl bg-white dark:bg-slate-800 shadow hover:shadow-xl border border-slate-200 dark:border-slate-700 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-full">+24%</span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Revenue</h3>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white">$1,240</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">This month</p>
                </div>
            </div>

            <!-- Chart + Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chart Placeholder -->
                <div class="lg:col-span-2 p-6 bg-white dark:bg-slate-800 rounded-2xl shadow border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Activity Overview</h3>
                    <div class="h-64 flex items-end gap-2">
                        @foreach([60,45,80,35,70,50,90] as $h)
                        <div class="flex-1 bg-cyan-500 rounded-t-xl hover:bg-cyan-600 transition-all" style="height: {{ $h }}%"></div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl shadow border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-3 rounded hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            <div class="w-2 h-2 mt-2 bg-cyan-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">New user registered</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            <div class="w-2 h-2 mt-2 bg-cyan-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">Order #1234 completed</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            <div class="w-2 h-2 mt-2 bg-gray-400 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">Payment received</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            <div class="w-2 h-2 mt-2 bg-gray-400 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">New review posted</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
