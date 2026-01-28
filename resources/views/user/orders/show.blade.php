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

            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Order Info --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Order Number</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ strtoupper($order->status) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Payment Method</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $order->payment_method === 'BANK_TRANSFER' ? 'BANK TRANSFER' : 'COD' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500">Shipping Address</p>
                                <p class="text-gray-900 dark:text-white">{{ $order->shipping_address }}</p>
                            </div>

                            @if($order->notes)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Notes</p>
                                    <p class="text-gray-900 dark:text-white">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Items</h3>

                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between border-b pb-3 dark:border-gray-700">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Box --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment</h3>

                            @php
                                $payment = $order->payment;
                            @endphp

                            @if($payment)
                                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                                    <div class="flex justify-between">
                                        <span>Status</span>
                                        <span class="font-semibold">{{ strtoupper($payment->status) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Amount</span>
                                        <span class="font-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Method</span>
                                        <span class="font-semibold">{{ $payment->method === 'BANK_TRANSFER' ? 'BANK TRANSFER' : 'COD' }}</span>
                                    </div>

                                    @if($payment->proof_path)
                                        <div class="mt-3 p-3 rounded bg-green-50 dark:bg-green-900/20">
                                            <p class="font-semibold text-green-700 dark:text-green-300">Proof uploaded</p>
                                            <p class="text-xs text-gray-500">Waiting confirmation</p>
                                        </div>
                                    @endif
                                </div>

                                @if($payment->method === 'BANK_TRANSFER' && $payment->status === 'pending')
                                    <a href="{{ route('payment.show', $order->id) }}"
                                       class="block text-center mt-5 bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                                        Pay Now
                                    </a>
                                @endif
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400">No payment record.</p>
                            @endif

                            <a href="{{ route('orders.index') }}" class="block w-full text-center text-gray-600 dark:text-gray-400 mt-4 hover:text-blue-600 transition">
                                Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
