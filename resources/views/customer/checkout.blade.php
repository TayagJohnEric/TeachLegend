@extends('layouts.customer.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6">Checkout</h2>

    <!-- Display Success and Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-400 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Checkout Form -->
    <form method="POST" action="{{ route('customer.checkout.process') }}">
        @csrf

        <!-- Shipping Address -->
        <div class="mb-4">
            <label for="shipping_address" class="block text-lg font-medium">Shipping Address</label>
            <input type="text" id="shipping_address" name="shipping_address" 
                   class="w-full border rounded-lg px-4 py-2" required 
                   value="{{ old('shipping_address') }}">
        </div>

        <!-- Payment Method -->
        <div class="mb-4">
            <label class="block text-lg font-medium">Payment Method</label>
            <select name="payment_method" class="w-full border rounded-lg px-4 py-2" required>
                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
            </select>
        </div>

        <!-- Order Summary -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold">Order Summary</h3>

            <!-- Cart Items -->
            @if(!$cartItems->isEmpty())
                <h4 class="text-lg font-semibold mt-4">Cart Items</h4>
                <ul class="mt-2">
                    @foreach ($cartItems as $item)
                        <li class="border-b py-2 flex justify-between">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- PC Build Summary -->
            @if($pcBuild)
                <h4 class="text-lg font-semibold mt-6">PC Build Summary</h4>
                <p><strong>Budget:</strong> ${{ number_format($pcBuild->budget, 2) }}</p>
                <ul class="mt-2">
                    @foreach ($selectedProducts as $product)
                        <li class="border-b py-2 flex justify-between">
                            <span>{{ $product->name }}</span>
                            <span>${{ number_format($product->price, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <input type="hidden" name="pc_build_id" value="{{ $pcBuild->id }}">
            @endif

            <!-- Total Cost -->
            <p class="text-lg font-bold mt-4">Total: ${{ number_format($totalAmount, 2) }}</p>
        </div>

        <!-- Checkout Button -->
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
            Place Order
        </button>
    </form>
</div>
@endsection
