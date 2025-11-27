@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Products Management</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your product catalog</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Products</h3>
            <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Product
            </a>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-lg transition">
                        <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $product->category }}</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-xs mt-1 {{ $product->stock < 25 ? 'text-orange-500' : 'text-gray-500 dark:text-gray-400' }}">
                            Stock: {{ $product->stock }} units {{ $product->stock < 25 ? '(Low Stock!)' : '' }}
                        </p>
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 px-3 py-1 rounded text-sm hover:bg-blue-100 dark:hover:bg-blue-900/40 transition text-center">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 dark:bg-red-900/20 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">No products yet. Create your first product!</p>
                <a href="{{ route('admin.products.create') }}" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Add Product
                </a>
            </div>
        @endif
    </div>
@endsection