<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Order Info --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Order #{{ $order->order_number }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Placed on {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        @if($order->status === 'pending')
                            <span class="px-4 py-2 text-lg bg-yellow-100 text-yellow-700 rounded-full font-semibold">Pending</span>
                        @else
                            <span class="px-4 py-2 text-lg bg-green-100 text-green-700 rounded-full font-semibold">Completed</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t dark:border-gray-700 pt-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Customer</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->user->email }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Shipping Address</h4>
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $order->shipping_address }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Payment Method</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->payment_method }}</p>
                            
                            @if($order->notes)
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 mt-4">Notes</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Items</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 border-b dark:border-gray-700 pb-4">
                                <div class="w-20 h-20 flex-shrink-0">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 rounded"></div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Price: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t dark:border-gray-700 pt-4 mt-4">
                        <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="flex gap-3">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>

                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>