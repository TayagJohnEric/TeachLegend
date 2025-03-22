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



class CustomerCheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('customer.checkout', compact('cartItems', 'totalAmount'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:credit_card,paypal,cash_on_delivery',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $totalAmount = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                    'price_at_purchase' => $cartItem->product->price,
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            SimulatedPayment::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : 'successful',
                'transaction_reference' => Str::random(12),
            ]);

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            // Update order status
            $order->update(['order_status' => ($request->payment_method === 'cash_on_delivery' ? 'processing' : 'completed')]);

            DB::commit();

            return redirect()->route('cart.view')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.view')->with('error', 'Something went wrong.');
        }
    }
}
