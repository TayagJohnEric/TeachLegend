<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SimulatedPayment;
use App\Models\PcBuildConfiguration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CustomerCheckoutController extends Controller
{
    // Display Checkout Page
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Get regular cart items
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        $totalCartAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Check if a PC Build is being checked out
        $pcBuild = null;
        $totalBuildAmount = 0;
        $selectedProducts = collect(); // Initialize an empty collection

        if ($request->has('pc_build_id')) {
            $pcBuild = PcBuildConfiguration::where('user_id', $user->id)
                ->where('id', $request->pc_build_id)
                ->first();

            if (!$pcBuild) {
                return redirect()->route('pc-builder.list')->with('error', 'PC Build not found.');
            }

            // Use selected_components directly (since Laravel automatically casts it to an array)
            $selectedComponentIds = is_array($pcBuild->selected_components) 
                ? $pcBuild->selected_components 
                : json_decode($pcBuild->selected_components, true);

            $selectedProducts = Product::whereIn('id', $selectedComponentIds)->get();

            // Calculate total cost of the PC Build
            $totalBuildAmount = $selectedProducts->sum('price');
        }

        $totalAmount = $totalCartAmount + $totalBuildAmount;

        return view('customer.checkout', compact('cartItems', 'totalAmount', 'pcBuild', 'selectedProducts'));
    }

    // Process Checkout
    // Process Checkout
public function processCheckout(Request $request)
{
    $request->validate([
        'shipping_address' => 'required|string|max:255',
        'payment_method' => 'required|in:credit_card,paypal,cod',
    ]);

    $user = Auth::user();
    $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
    $pcBuild = null;
    $totalBuildAmount = 0;

    DB::beginTransaction();
    try {
        $order = Order::create([
            'user_id' => $user->id,
            'order_status' => 'pending',
            'total_amount' => 0, // Will be updated later
            'shipping_address' => $request->shipping_address,
        ]);

        $totalAmount = 0;

        // Process PC Build if exists
        if ($request->has('pc_build_id')) {
            $pcBuild = PcBuildConfiguration::where('user_id', $user->id)
                ->where('id', $request->pc_build_id)
                ->first();

            if (!$pcBuild) {
                throw new \Exception('Invalid PC Build.');
            }

            // Use selected_components directly
            $selectedComponentIds = is_array($pcBuild->selected_components) 
                ? $pcBuild->selected_components 
                : json_decode($pcBuild->selected_components, true);

            $selectedProducts = Product::whereIn('id', $selectedComponentIds)->get();

            foreach ($selectedProducts as $product) {
                if ($product->stock < 1) {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price_at_purchase' => $product->price,
                ]);

                $product->decrement('stock');
                $totalBuildAmount += $product->price;
            }

            // ✅ Remove PC Build after successful checkout
            $pcBuild->delete();
        }

        // Process Cart Items
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
            $totalAmount += $cartItem->product->price * $cartItem->quantity;
        }

        $totalAmount += $totalBuildAmount;

        // Update Order Total
        $order->update(['total_amount' => $totalAmount]);

        // Process Payment
        $paymentStatus = in_array($request->payment_method, ['credit_card', 'paypal']) ? 'completed' : 'pending';
        SimulatedPayment::create([
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
