<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Tampilkan semua products
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('stock', '>', 0)->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('user.shop.index', compact('products', 'categories'));
    }

    // Detail product
    public function show(Product $product)
    {
        return view('user.shop.show', compact('product'));
    }
}