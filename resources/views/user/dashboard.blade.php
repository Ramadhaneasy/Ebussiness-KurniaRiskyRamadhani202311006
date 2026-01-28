<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-sky-900">Welcome Back, {{ Auth::user()->name }}!</h2>
                <p class="text-sm text-sky-700 mt-1">Order Tracking</p>
            </div>

            <a href="{{ route('orders.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">
                View Orders
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </x-slot>

    {{-- Alerts --}}
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

    {{-- ORDER TRACKING --}}
    <div class="rounded-2xl border border-sky-100 bg-white/70 p-5 mb-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-extrabold text-sky-900">Order Tracking</h3>
            <span class="text-xs font-semibold text-sky-700 px-3 py-1 rounded-full border border-sky-100 bg-sky-50">
                {{ $trackedOrder ? 'Active Order' : 'No Active Order' }}
            </span>
        </div>

        {{-- Stepper --}}
        @php
            $steps = [
                'payment_pending' => 'Payment pending',
                'packaging' => 'Packaging',
                'shipped' => 'Shipped',
                'completed' => 'Completed',
            ];

            $orderStepOrder = ['payment_pending', 'packaging', 'shipped', 'completed'];
            $activeIndex = array_search($trackingStep, $orderStepOrder);
        @endphp

        <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-2">
            @foreach($orderStepOrder as $i => $key)
                @php
                    $isActive = $i === $activeIndex;
                    $isDone = $i < $activeIndex;
                @endphp

                <div class="px-3 py-2 rounded-xl border text-center text-xs font-semibold
                    {{ $isActive ? 'bg-sky-600 border-sky-600 text-white' : ($isDone ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : 'bg-white/60 border-sky-100 text-sky-900') }}">
                    {{ $steps[$key] }}
                </div>
            @endforeach
        </div>

        {{-- Tracked Order Card --}}
        <div class="mt-4 rounded-2xl border border-sky-100 bg-white/70 p-5">
            @if(!$trackedOrder)
                <div class="text-center text-gray-600 py-6">
                    Belum ada order. Yuk belanja dulu 🙂
                    <div class="mt-3">
                        <a href="{{ route('shop.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">
                            Go to Shop
                        </a>
                    </div>
                </div>
            @else
                @php
                    $firstItem = $trackedOrder->items->first();
                    $payment = $trackedOrder->payment;
                    $needsPayment = $trackedOrder->payment_method === 'BANK_TRANSFER';
                    $paymentPending = $needsPayment && $payment && $payment->status === 'pending';
                    $badge = $paymentPending ? 'Pending Payment' : strtoupper($trackedOrder->status ?? 'PENDING');
                    $badgeClass = $paymentPending
                        ? 'bg-amber-50 text-amber-700 border-amber-100'
                        : 'bg-sky-50 text-sky-700 border-sky-100';
                @endphp

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="text-lg font-extrabold text-sky-900">
                                {{ $trackedOrder->order_number }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                {{ $badge }}
                            </span>
                        </div>

                        <div class="mt-2 text-sm text-gray-700">
                            <div class="font-semibold">
                                {{ $firstItem?->product_name ?? 'Product' }}
                                @if($trackedOrder->items->count() > 1)
                                    <span class="text-gray-500">+ {{ $trackedOrder->items->count() - 1 }} item(s)</span>
                                @endif
                            </div>
                            <div class="text-gray-600 mt-1">
                                Total: <span class="font-semibold">Rp {{ number_format($trackedOrder->total_amount, 0, ',', '.') }}</span>
                                <span class="mx-2 text-gray-300">•</span>
                                Method: <span class="font-semibold">{{ $trackedOrder->payment_method }}</span>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 mt-3">
                            Submitted {{ $trackedOrder->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('orders.show', $trackedOrder->id) }}"
                           class="px-4 py-2 rounded-xl border border-sky-100 bg-white/60 hover:bg-sky-50 transition font-semibold text-sky-900 text-center">
                            View Details
                        </a>

                        @if($trackedOrder->payment_method === 'BANK_TRANSFER')
                            <a href="{{ route('payment.show', $trackedOrder->id) }}"
                               class="px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition text-center">
                                Complete Payment
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="rounded-2xl border border-sky-100 bg-white/70 overflow-hidden">
        <div class="p-5 flex items-center justify-between">
            <h3 class="text-lg font-extrabold text-sky-900">My Recent Orders</h3>
            <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-sky-700 hover:text-sky-900">
                View All
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="p-6 text-center text-gray-600">
                Belum ada order.
            </div>
        @else
            <div class="divide-y divide-sky-100">
                @foreach($recentOrders as $order)
                    @php
                        $payment = $order->payment;
                        $needsPayment = $order->payment_method === 'BANK_TRANSFER';
                        $paymentPending = $needsPayment && $payment && $payment->status === 'pending';

                        $badge = $paymentPending ? 'Pending Payment' : strtoupper($order->status ?? 'PENDING');
                        $badgeClass = $paymentPending
                            ? 'bg-amber-50 text-amber-700 border-amber-100'
                            : 'bg-emerald-50 text-emerald-700 border-emerald-100';

                        $firstItem = $order->items->first();
                    @endphp

                    <div class="p-5 hover:bg-sky-50/60 transition">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <div class="font-extrabold text-sky-900">{{ $order->order_number }}</div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                        {{ $badge }}
                                    </span>
                                </div>

                                <div class="text-sm text-gray-700 mt-2">
                                    <div class="font-semibold">
                                        {{ $firstItem?->product_name ?? 'Product' }}
                                        @if($order->items->count() > 1)
                                            <span class="text-gray-500">+ {{ $order->items->count() - 1 }} item(s)</span>
                                        @endif
                                    </div>

                                    <div class="text-gray-600 mt-1">
                                        Total: <span class="font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        {{ $order->created_at->diffForHumans() }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Method: {{ $order->payment_method }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                @if($needsPayment)
                                    <a href="{{ route('payment.show', $order->id) }}"
                                       class="px-4 py-2 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition">
                                        Complete Payment
                                    </a>
                                @else
                                    <a href="{{ route('orders.show', $order->id) }}"
                                       class="px-4 py-2 rounded-xl border border-sky-100 bg-white/60 hover:bg-sky-50 transition font-semibold text-sky-900">
                                        View Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
