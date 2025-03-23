<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class AdminManageProductController extends Controller
{
    public function index(){
        $products = Product::with('category')->get();
        $categories = Category::all();
       return view('admin.manage_products', compact('products', 'categories'));
    }

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'description' => 'nullable|string',
        'motherboards' => 'nullable|string',
        'socket_type' => 'nullable|string',
        'ram_type' => 'nullable|string',
        'storage_type' => 'nullable|string',
        'gpu_pcie_slot' => 'nullable|string',
        'os_compatibility' => 'nullable|string',
    ]);

    // Handle image upload
    $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

    // Format compatibility data
    $compatibilityData = [
        'motherboards' => $request->motherboards ? explode(',', $request->motherboards) : [],
        'socket_type' => $request->socket_type,
        'ram_type' => $request->ram_type,
        'storage_type' => $request->storage_type,
        'gpu_pcie_slot' => $request->gpu_pcie_slot,
        'os_compatibility' => $request->os_compatibility,
    ];

    // Store product
    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath,
        'description' => $request->description,
        'compatibility_data' => $compatibilityData,
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
}


    public function edit(Product $product)
{
    return response()->json($product);
}

public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'motherboards' => 'nullable|string',
        'socket_type' => 'nullable|string',
        'ram_type' => 'nullable|string',
        'storage_type' => 'nullable|string',
        'gpu_pcie_slot' => 'nullable|string',
        'os_compatibility' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // Store new image
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

   // In your update method
$validated['compatibility_data'] = json_encode([
    'motherboards' => $request->motherboards ? explode(',', $request->motherboards) : [],
    'socket_type' => $request->socket_type,
    'ram_type' => $request->ram_type,
    'storage_type' => $request->storage_type,
    'gpu_pcie_slot' => $request->gpu_pcie_slot,
    'os_compatibility' => $request->os_compatibility,
]);

    $product->update($validated);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product updated successfully.');
}


    public function destroy(Product $product)
    {
        // Delete the product image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

}
