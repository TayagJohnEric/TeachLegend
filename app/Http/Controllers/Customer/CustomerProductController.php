<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class CustomerProductController extends Controller
{
    public function index(Request $request)
{
    // Get all categories for the filter dropdown
    $categories = Category::all();

    // Start with a base query
    $query = Product::with('category');

    // Apply category filter if specified
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }

    // Apply sorting if specified
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest();
    }

    // Get paginated results (even if empty)
    $products = $query->paginate(12);

    // Get the selected category (if any) for better UI messages
    $selectedCategory = null;
    if ($request->has('category') && $request->category) {
        $selectedCategory = Category::find($request->category);
    }

    return view('customer.browse_products', compact('products', 'categories', 'selectedCategory'));
}

    public function show($id)
{
    $product = Product::with('category')->findOrFail($id);
    return response()->json($product);
}

}
