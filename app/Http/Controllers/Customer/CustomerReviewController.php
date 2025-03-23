<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    
    // Store a new review
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:500',
        ]);

        // Create review
        Review::create([
            'user_id' => Auth::id(), 
            'product_id' => $productId,
            'rating' => $request->rating,
            'review_text' => $request->review_text
        ]);

        return response()->json(['message' => 'Review added successfully!']);
    }
}
