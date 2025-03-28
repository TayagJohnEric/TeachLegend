<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PcBuildConfiguration;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerPcBuildConfigurationController extends Controller
{
    // Display the PC Builder Page with categorized products
    public function index()
    {
        $categories = Product::with('category')
            ->select('category_id', DB::raw('GROUP_CONCAT(id) as product_ids'))
            ->groupBy('category_id')
            ->get()
            ->mapWithKeys(function ($item) {
                if ($item->category_id) {
                    $category = Category::find($item->category_id);
                    if ($category) {
                        return [$category->name => Product::whereIn('id', explode(',', $item->product_ids))->get()];
                    }
                }
                return [];
            });

        return view('customer.pc_builder_index', [
            'categories' => $categories,
        ]);
    }

    // Store a new PC Build Configuration
    public function store(Request $request)
    {
        // Validate user input
        $request->validate([
            'selected_components' => 'required|array|min:4|max:10',
            'selected_components.*' => 'exists:products,id',
            'budget' => 'required|numeric|min:500|max:500000', // Updated limits
        ], [
            'selected_components.required' => 'You must select at least 4 components.',
            'budget.required' => 'Please enter a budget.',
            'budget.min' => 'Budget must be at least $500.',
            'budget.max' => 'Budget cannot exceed $500,000.',
        ]);
        

        // Calculate total build cost
        $totalCost = Product::whereIn('id', $request->selected_components)->sum('price');

        // Ensure total cost does not exceed budget
        if ($totalCost > $request->budget) {
            return back()
                ->withInput()
                ->withErrors(['budget' => 'Total component cost exceeds your budget.']);
        }

        // Store PC Build Configuration
        $pcBuild = PcBuildConfiguration::create([
            'user_id' => Auth::id(),
            'selected_components' => $request->selected_components, // No need for json_encode() due to model casting
            'budget' => $request->budget,
            'total_cost' => $totalCost,
        ]);

        return redirect()
            ->route('pc-builder.show', $pcBuild->id)
            ->with('success', 'PC Build saved successfully!');
    }

    // Show a specific PC Build Configuration
    public function show($id)
{
    $pcBuild = PcBuildConfiguration::with('user')->findOrFail($id);

    // Ensure selected_components is an array
    $selectedComponents = is_array($pcBuild->selected_components) 
        ? $pcBuild->selected_components 
        : json_decode($pcBuild->selected_components, true);

    $selectedProducts = Product::whereIn('id', $selectedComponents ?? [])->get();

    return view('customer.pc_builder_show', [
        'pcBuild' => $pcBuild,
        'selectedProducts' => $selectedProducts
    ]);
}

    // List user's saved PC builds
    public function list()
    {
        if (!Auth::check()) {
            abort(403, 'User not authenticated');
        }

        $pcBuilds = PcBuildConfiguration::where('user_id', Auth::id())->latest()->paginate(5);

        return view('customer.pc_builder_list', compact('pcBuilds'));
    }

    // Delete a saved PC build
    public function destroy($id)
    {
        $pcBuild = PcBuildConfiguration::findOrFail($id);

        // Ensure the PC build belongs to the authenticated user before deleting
        if ($pcBuild->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pcBuild->delete();

        return redirect()
            ->route('pc-builder.list')
            ->with('success', 'PC Build deleted successfully.');
    }
}
