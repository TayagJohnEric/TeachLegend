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
        $totalProducts = $cartItems->sum('quantity');
        return view('customer.cart', compact('cartItems','totalProducts'));
    }


    public function updateCart(Request $request, $cartId)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $cartItem = Cart::findOrFail($cartId);
    $product = $cartItem->product;

    // Ensure quantity does not exceed stock
    $newQuantity = min($request->quantity, $product->stock);
    $cartItem->update(['quantity' => $newQuantity]);

    return response()->json(['success' => 'Cart updated successfully.']);
}



    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to your cart.');
        }

        $user = Auth::user();
        $product = Product::findOrFail($productId);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Selected quantity exceeds available stock.');
        }

        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $newQuantity = min($cartItem->quantity + $quantity, $product->stock);
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }


    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        
        return redirect()->route('cart.index')->with('success', 'Cart has been emptied.');
    }

}


