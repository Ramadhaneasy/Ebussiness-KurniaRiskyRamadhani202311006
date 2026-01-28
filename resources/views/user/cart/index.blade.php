<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-sky-900">Shopping Cart</h2>
                <p class="text-sm text-sky-700 mt-1">Atur quantity, lalu checkout.</p>
            </div>

            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-sky-100 bg-white/70 hover:bg-sky-50 transition font-semibold text-sky-900">
                Lanjut Belanja
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="rounded-2xl border border-sky-100 bg-white/70 p-10 text-center text-gray-600">
            Cart kamu kosong. Yuk belanja dulu 🙂
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($carts as $cart)
                    <div class="rounded-2xl border border-sky-100 bg-white/70 p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="font-extrabold text-sky-900 text-lg truncate">
                                    {{ $cart->product->name }}
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                    <span class="mx-2 text-gray-300">•</span>
                                    Stock: {{ $cart->product->stock }}
                                </div>
                            </div>

                            <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-xl border border-rose-100 bg-rose-50 text-rose-700 font-semibold hover:bg-rose-100 transition">
                                    Remove
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-4">
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')

                                <label class="text-sm font-semibold text-sky-900">Qty</label>
                                <input type="number" name="quantity" min="1" value="{{ $cart->quantity }}"
                                       class="w-24 rounded-xl border border-sky-100 bg-white/70 px-3 py-2 focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                                <button class="rounded-xl bg-sky-600 text-white font-semibold px-4 py-2 hover:bg-sky-700 transition">
                                    Update
                                </button>
                            </form>

                            <div class="text-right">
                                <div class="text-xs text-gray-500">Subtotal</div>
                                <div class="text-lg font-extrabold text-sky-900">
                                    Rp {{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl border border-sky-100 bg-white/70 p-6 sticky top-24">
                    <h3 class="text-lg font-extrabold text-sky-900">Summary</h3>

                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Shipping</span>
                            <span class="font-semibold text-emerald-700">FREE</span>
                        </div>

                        <div class="border-t border-sky-100 pt-3 mt-3 flex justify-between">
                            <span class="font-extrabold text-sky-900">Total</span>
                            <span class="font-extrabold text-sky-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="mt-5 block text-center rounded-xl bg-sky-600 text-white font-semibold px-4 py-3 hover:bg-sky-700 transition">
                        Checkout
                    </a>

                    <p class="text-xs text-gray-500 mt-3">
                        Pastikan qty tidak melebihi stok ya.
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
