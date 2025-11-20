<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            User Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-lg font-semibold">User Dashboard</h3>
                <p>Orders Today: {{ $ordersToday }}</p>
                <p>Revenue Today: {{ $revenueToday }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
