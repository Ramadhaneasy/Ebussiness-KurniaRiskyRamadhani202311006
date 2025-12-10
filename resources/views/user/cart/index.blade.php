<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success/Error Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($carts->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Cart Items --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Cart Items ({{ $carts->count() }})</h3>
                                
                                @foreach($carts as $cart)
                                    <div class="flex items-center gap-4 border-b dark:border-gray-700 py-4">
                                        <div class="w-20 h-20 flex-shrink-0">
                                            @if($cart->product->image)
                                                <img src="{{ Storage::url($cart->product->image) }}" alt="{{ $cart->product->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-600 rounded"></div>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $cart->product->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $cart->product->category }}</p>
                                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                        </div>

                                        <form action="{{ route('cart.update', $cart) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}"
                                                class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white text-center"
                                                onchange="this.form.submit()">
                                        </form>

                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}</p>
                                        </div>

                                        <form action="{{ route('cart.remove', $cart) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Remove this item?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h3>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                        <span>Subtotal</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                        <span>Shipping</span>
                                        <span>FREE</span>
                                    </div>
                                    <div class="border-t dark:border-gray-700 pt-2 mt-2">
                                        <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                            <span>Total</span>
                                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-500 text-white text-center px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                                    Proceed to Checkout
                                </a>

                                <a href="{{ route('shop.index') }}" class="block w-full text-center text-gray-600 dark:text-gray-400 mt-3 hover:text-blue-600 transition">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Your cart is empty</p>
                        <a href="{{ route('shop.index') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>