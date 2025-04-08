<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeInListing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




class CustomerTradeInController extends Controller
{
    
/**
     * Display a listing of the trade-in items.
     */
    public function index(Request $request)
    {
        $query = TradeInListing::where('status', 'Available');

        // Apply filters if they exist
        if ($request->has('component_type') && $request->component_type != '') {
            $query->where('component_type', $request->component_type);
        }

        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->has('condition') && $request->condition != '') {
            $query->where('condition', $request->condition);
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('pricing', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('pricing', '<=', $request->max_price);
        }

        // Get component types for filter
        $componentTypes = TradeInListing::distinct()
            ->where('status', 'Available')
            ->pluck('component_type')
            ->filter()
            ->toArray();

        // Get brands for filter
        $brands = TradeInListing::distinct()
            ->where('status', 'Available')
            ->pluck('brand')
            ->filter()
            ->toArray();

        $listings = $query->latest()->paginate(12);

        return view('customer.trade_in_index', compact('listings', 'componentTypes', 'brands'));
    }

    /**
     * Show the form for creating a new trade-in listing.
     */
    public function create()
    {
        return view('customer.trade_in_create');
    }

    /**
     * Store a newly created trade-in listing.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'component_type' => 'required|string',
            'brand' => 'required|string|max:255',
            'component_details' => 'required|string',
            'condition' => 'required|in:Like New,Used,Needs Repair',
            'pricing' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trade-in-images', 'public');
        }

        $listing = TradeInListing::create([
            'user_id' => Auth::id(),
            'component_type' => $validatedData['component_type'],
            'brand' => $validatedData['brand'],
            'component_details' => $validatedData['component_details'],
            'condition' => $validatedData['condition'],
            'pricing' => $validatedData['pricing'],
            'image_path' => $imagePath,
            'status' => 'Available',
        ]);

        return redirect()->route('trade-in.index', $listing)
            ->with('success', 'Trade-in listing created successfully!');
    }

    /**
 * Display the specified trade-in listing.
 */
public function show(TradeInListing $tradeIn)
{
    // Check if the user is authorized to view the details
    // This is optional but a good security measure
   
    
    // Increment view count only if the viewer is not the owner
    if (Auth::id() !== $tradeIn->user_id) {
        $tradeIn->increment('views');
    }
    
    return view('customer.trade_in_show', compact('tradeIn'));
}

/**
 * Show the form for editing the specified trade-in listing.
 */
public function edit(TradeInListing $tradeIn)
{
    // Strict authorization check
    if (Auth::id() !== $tradeIn->user_id) {
        return redirect()->route('trade-in.my-listings')
            ->with('error', 'You are not authorized to edit this listing.');
    }

    // Get any needed reference data for dropdowns
    $conditions = ['New', 'Like New', 'Good', 'Used', 'Needs Repair'];
    $statuses = ['Available', 'Pending', 'Sold', 'Removed'];
    
    return view('customer.trade_in_edit', compact('tradeIn', 'conditions', 'statuses'));
}

/**
 * Update the specified trade-in listing.
 */
public function update(Request $request, TradeInListing $tradeIn)
{
    // Strict authorization check
    if (Auth::id() !== $tradeIn->user_id) {
        return redirect()->route('trade-in.my-listings')
            ->with('error', 'You are not authorized to update this listing.');
    }

    $validatedData = $request->validate([
        'component_type' => 'required|string',
        'brand' => 'required|string|max:255',
        'component_details' => 'required|string',
        'condition' => 'required|in:New,Like New,Good,Used,Needs Repair',
        'pricing' => 'required|numeric|min:0',
        'status' => 'required|in:Available,Pending,Sold,Removed',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($tradeIn->image_path) {
            Storage::disk('public')->delete($tradeIn->image_path);
        }
        $validatedData['image_path'] = $request->file('image')->store('trade-in-images', 'public');
    }

    $tradeIn->update($validatedData);

    // Redirect back to my-listings with success message
    return redirect()->route('trade-in.my-listings')
        ->with('success', 'Trade-in listing updated successfully!');
}

/**
 * Update the status of the specified trade-in listing.
 */
public function updateStatus(Request $request, TradeInListing $tradeIn)
{
    // Strict authorization check
    if (Auth::id() !== $tradeIn->user_id) {
        return redirect()->route('trade-in.my-listings')
            ->with('error', 'You are not authorized to update this listing.');
    }

    $validatedData = $request->validate([
        'status' => 'required|in:Available,Pending,Sold,Removed',
    ]);

    $tradeIn->update(['status' => $validatedData['status']]);

    // Redirect back to my-listings since that's where the status would likely be updated from
    return redirect()->route('trade-in.my-listings')
        ->with('success', 'Listing status updated successfully!');
}

/**
 * Remove the specified trade-in listing.
 */
public function destroy(TradeInListing $tradeIn)
{
    // Strict authorization check
    if (Auth::id() !== $tradeIn->user_id) {
        return redirect()->route('trade-in.my-listings')
            ->with('error', 'You are not authorized to delete this listing.');
    }

    // Delete image if exists
    if ($tradeIn->image_path) {
        Storage::disk('public')->delete($tradeIn->image_path);
    }

    $tradeIn->delete();

    // Redirect back to my-listings page since that's where the delete action was triggered
    return redirect()->route('trade-in.my-listings')
        ->with('success', 'Trade-in listing deleted successfully!');
}

    /**
     * Display listings for the authenticated user.
     */
    public function myListings()
    {
        $listings = TradeInListing::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.my_listings', compact('listings'));
    }

}
