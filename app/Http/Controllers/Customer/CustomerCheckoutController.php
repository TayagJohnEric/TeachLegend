<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SimulatedPayment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CustomerCheckoutController extends Controller
{
    
   // Display Checkout Page
   public function checkout()
   {
       $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
       
       if ($cartItems->isEmpty()) {
           return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
       }

       $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

       return view('customer.checkout', compact('cartItems', 'totalAmount'));
   }

   // Process Checkout
   public function processCheckout(Request $request)
   {
       $request->validate([
           'shipping_address' => 'required|string|max:255',
           'payment_method' => 'required|in:credit_card,paypal,cod',
       ]);
   
       $user = Auth::user();
       $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
   
       if ($cartItems->isEmpty()) {
           return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
       }
   
       $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
   
       DB::beginTransaction();
       try {
           // Create an Order
           $order = Order::create([
               'user_id' => $user->id,
               'order_status' => 'pending',
               'total_amount' => $totalAmount,
               'shipping_address' => $request->shipping_address,
           ]);
   
           // Create Order Items and Deduct Stock
           foreach ($cartItems as $cartItem) {
               $product = $cartItem->product;
   
               if ($cartItem->quantity > $product->stock) {
                   throw new \Exception("Product {$product->name} is out of stock.");
               }
   
               OrderItem::create([
                   'order_id' => $order->id,
                   'product_id' => $product->id,
                   'quantity' => $cartItem->quantity,
                   'price_at_purchase' => $product->price,
               ]);
   
               $product->decrement('stock', $cartItem->quantity);
           }
   
           // Determine Payment Status based on Payment Method
           $paymentStatus = in_array($request->payment_method, ['credit_card', 'paypal']) ? 'completed' : 'pending';
           // Create Simulated Payment
           $payment = SimulatedPayment::create([
               'user_id' => $user->id,
               'order_id' => $order->id,
               'payment_method' => $request->payment_method,
               'payment_status' => $paymentStatus,
               'transaction_reference' => Str::random(10),
           ]);
   
           // Clear Cart
           Cart::where('user_id', $user->id)->delete();
   
           DB::commit();
           return redirect()->route('customer.orders')->with('success', 'Order placed successfully.');
       } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->route('customer.checkout')->with('error', $e->getMessage());
       }
   }
   
}
