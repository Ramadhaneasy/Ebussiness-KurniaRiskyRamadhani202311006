<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment - Bank Transfer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order: {{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total: <span class="font-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Payment Status: <span class="font-semibold">{{ strtoupper($payment->status) }}</span></p>
                        </div>

                        <a href="{{ route('orders.show', $order->id) }}"
                           class="text-sm text-blue-600 hover:underline">
                            Back to Order
                        </a>
                    </div>

                    <div class="mt-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                        <p class="font-semibold text-gray-900 dark:text-white mb-2">Transfer to:</p>
                        <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                            <li><span class="font-semibold">Bank:</span> BCA</li>
                            <li><span class="font-semibold">Account Number:</span> 1234567890</li>
                            <li><span class="font-semibold">Account Name:</span> E-Business Store</li>
                            <li><span class="font-semibold">Amount:</span> Rp {{ number_format($payment->amount, 0, ',', '.') }}</li>
                        </ul>
                        <p class="text-xs text-gray-500 mt-3">
                            * Kamu bisa ganti data rekening ini sesuai kebutuhan tugas.
                        </p>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Upload Payment Proof</h4>

                        @if($payment->proof_path)
                            <div class="p-3 rounded bg-green-50 dark:bg-green-900/20 mb-4">
                                <p class="font-semibold text-green-700 dark:text-green-300">Proof already uploaded</p>
                                <p class="text-xs text-gray-500">Waiting confirmation</p>
                            </div>
                        @endif

                        <form action="{{ route('payment.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="file" name="proof"
                                   class="block w-full text-sm text-gray-700 dark:text-gray-200
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-500 file:text-white
                                          hover:file:bg-blue-600"
                                   required>

                            @error('proof')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror

                            <button type="submit"
                                    class="mt-4 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-semibold">
                                Upload Proof
                            </button>
                        </form>

                        <p class="text-xs text-gray-500 mt-3">
                            Format: JPG/JPEG/PNG/PDF, max 2MB.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
