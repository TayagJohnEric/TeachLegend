<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


class CustomerCartController extends Controller
{
  
    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        return view('customer.cart', compact('cartItems'));
    }


    public function addToCart($productId)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to your cart.');
        }

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Check if the product is already in the user's cart
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            // If exists, increase the quantity
            $cartItem->increment('quantity');
        } else {
            // If not, add new entry
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }



    public function removeFromCart($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($id);
        
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'You do not have permission to update this item.');
        }
        
        // Check product stock availability
        $product = Product::findOrFail($cartItem->product_id);
        if ($request->quantity > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'The requested quantity exceeds available stock.');
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return redirect()->route('cart.index')->with('success', 'Cart has been emptied.');
    }

}


