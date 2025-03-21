<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class CustomerCategoryController extends Controller
{
   

    public function show(Category $category)
    {
        // Load the products related to the given category using eager loading
        $category->load('products');
    
        return view('customer.browse_products', compact('category'));
    }
}
