@extends('layouts.customer.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6">Checkout</h2>

    <form method="POST" action="{{ route('customer.checkout.process') }}">
        @csrf

        <div class="mb-4">
            <label for="shipping_address" class="block text-lg font-medium">Shipping Address</label>
            <input type="text" id="shipping_address" name="shipping_address" class="w-full border rounded-lg px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-lg font-medium">Payment Method</label>
            <select name="payment_method" class="w-full border rounded-lg px-4 py-2" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cod">Cash on Delivery</option>
            </select>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-semibold">Order Summary</h3>
            <ul class="mt-4">
                @foreach ($cartItems as $item)
                    <li class="border-b py-2">
                        {{ $item->product->name }} (x{{ $item->quantity }}) - ${{ number_format($item->product->price * $item->quantity, 2) }}
                    </li>
                @endforeach
            </ul>
            <p class="text-lg font-bold mt-4">Total: ${{ number_format($totalAmount, 2) }}</p>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
            Place Order
        </button>
    </form>
</div>
@endsection
