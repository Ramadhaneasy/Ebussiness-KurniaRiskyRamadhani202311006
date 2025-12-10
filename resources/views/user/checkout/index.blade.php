<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Shipping Info --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shipping Information</h3>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" value="{{ auth()->user()->name }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Shipping Address *</label>
                                    <textarea name="shipping_address" rows="4" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white @error('shipping_address') border-red-500 @enderror"
                                        placeholder="Enter your complete shipping address...">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Notes (Optional)</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Method</h3>
                                
                                <div class="flex items-center p-4 border-2 border-blue-500 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">Cash on Delivery (COD)</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Pay when you receive the product</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h3>
                                
                                <div class="space-y-3 mb-4">
                                    @foreach($carts as $cart)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">
                                                {{ $cart->product->name }} <span class="text-gray-500">(x{{ $cart->quantity }})</span>
                                            </span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="border-t dark:border-gray-700 pt-4 space-y-2">
                                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                        <span>Subtotal</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                        <span>Shipping</span>
                                        <span class="text-green-600">FREE</span>
                                    </div>
                                    <div class="border-t dark:border-gray-700 pt-2 mt-2">
                                        <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                            <span>Total</span>
                                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                                    Place Order
                                </button>

                                <a href="{{ route('cart.index') }}" class="block w-full text-center text-gray-600 dark:text-gray-400 mt-3 hover:text-blue-600 transition">
                                    Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>