<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-sky-900">My Orders</h2>
                <p class="text-sm text-sky-700 mt-1">Lihat status pesanan & pembayaran kamu.</p>
            </div>

            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">
                Belanja Lagi
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

    @if($orders->isEmpty())
        <div class="rounded-2xl border border-sky-100 bg-white/70 p-10 text-center text-gray-600">
            Belum ada order. Yuk checkout produk pertama kamu 🙂
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                @php
                    $badgeStatus = $order->status === 'paid'
                        ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                        : 'bg-amber-50 text-amber-700 border-amber-100';

                    $methodBadge = $order->payment_method === 'BANK_TRANSFER'
                        ? 'bg-sky-50 text-sky-700 border-sky-100'
                        : 'bg-violet-50 text-violet-700 border-violet-100';

                    $payment = $order->payment ?? null;
                @endphp

                <div class="rounded-2xl border border-sky-100 bg-white/70 p-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="font-extrabold text-sky-900">{{ $order->order_number }}</div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeStatus }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $methodBadge }}">
                                {{ $order->payment_method === 'BANK_TRANSFER' ? 'BANK TRANSFER' : 'COD' }}
                            </span>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold border border-sky-100 bg-white/60 text-sky-900">
                                Items: {{ $order->items->count() }}
                            </span>

                            <span class="px-3 py-1 rounded-full text-xs font-extrabold border border-sky-100 bg-white/60 text-sky-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white/70 border border-sky-100 hover:bg-sky-50 transition font-semibold text-sky-900">
                            View Details
                        </a>

                        @if($order->payment_method === 'BANK_TRANSFER' && $payment && $payment->status === 'pending')
                            <a href="{{ route('payment.show', $order->id) }}"
                               class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">
                                Pay Now
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-app-layout>
