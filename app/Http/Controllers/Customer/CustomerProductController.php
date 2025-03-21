<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

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
                    $query->latest(); // Default to newest
            }
        } else {
            $query->latest(); // Default sorting
        }
        
        // Get paginated results
        $products = $query->paginate(12);
        
        return view('customer.browse_products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
