<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->rating = $request->rating;
            $existingReview->review_text = $request->review_text;
            $existingReview->save();

            return redirect()->back()->with('success', 'Your review has been updated!');
        }

        // Create new review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    /**
     * Show the form for creating a new review.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function create($productId)
    {
        // Check if product exists
        $product = Product::findOrFail($productId);
        
        // Check if user already reviewed this product
        $existingReview = null;
        if (Auth::check()) {
            $existingReview = Review::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
        }
        
        return view('reviews.create', [
            'product' => $product,
            'existingReview' => $existingReview
        ]);
    }

    /**
     * Get reviews for a specific product.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function getProductReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return response()->json($reviews);
    }
}
