<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-sky-900">Shop</h2>
                <p class="text-sm text-sky-700 mt-1">Cari produk, pilih kategori, lalu checkout.</p>
            </div>

            <a href="{{ route('cart.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-sky-100 bg-white/70 hover:bg-sky-50 transition font-semibold text-sky-900">
                <svg class="w-5 h-5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
                Cart
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

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('shop.index') }}"
          class="mb-6 rounded-2xl border border-sky-100 bg-white/70 p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-sky-900 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari produk..."
                       class="w-full rounded-xl border border-sky-100 bg-white/70 px-4 py-2.5 focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
            </div>

            <div>
                <label class="block text-sm font-semibold text-sky-900 mb-1">Category</label>
                <select name="category"
                        class="w-full rounded-xl border border-sky-100 bg-white/70 px-4 py-2.5 focus:ring-2 focus:ring-sky-300 focus:border-sky-300">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button class="flex-1 rounded-xl bg-sky-600 text-white font-semibold px-4 py-2.5 hover:bg-sky-700 transition">
                    Filter
                </button>
                <a href="{{ route('shop.index') }}"
                   class="rounded-xl border border-sky-100 bg-white/70 font-semibold px-4 py-2.5 hover:bg-sky-50 transition text-sky-900">
                    Reset
                </a>
            </div>
        </div>
    </form>

    {{-- Products --}}
    @if($products->isEmpty())
        <div class="rounded-2xl border border-sky-100 bg-white/70 p-10 text-center text-gray-600">
            Produk tidak ditemukan.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($products as $product)
                <div class="rounded-2xl border border-sky-100 bg-white/70 overflow-hidden hover:shadow-md transition">
                    <div class="h-44 bg-gradient-to-br from-sky-100 to-white relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border border-sky-100 bg-white/70 text-sky-800">
                                {{ $product->category }}
                            </span>
                        </div>

                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border
                                {{ $product->stock > 0 ? 'border-emerald-100 bg-emerald-50 text-emerald-700' : 'border-rose-100 bg-rose-50 text-rose-700' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-extrabold text-sky-900 text-lg leading-tight">
                            {{ $product->name }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                            {{ $product->description ?: 'Produk terbaik untuk kebutuhan kamu.' }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-lg font-extrabold text-sky-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">Stock: {{ $product->stock }}</div>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4 flex gap-2">
                            @csrf
                            <input type="number" name="quantity" min="1" value="1"
                                   class="w-24 rounded-xl border border-sky-100 bg-white/70 px-3 py-2 focus:ring-2 focus:ring-sky-300 focus:border-sky-300"
                                   {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <button type="submit"
                                    class="flex-1 rounded-xl bg-sky-600 text-white font-semibold px-4 py-2 hover:bg-sky-700 transition disabled:opacity-50"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</x-app-layout>
