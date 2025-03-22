@extends('layouts.customer.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Checkout</h2>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Shipping Address</label>
            <input type="text" name="shipping_address" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Payment Method</label>
            <select name="payment_method" class="border p-2 w-full" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash_on_delivery">Cash on Delivery</option>
            </select>
        </div>

        <div class="mb-6">
            <p class="text-lg font-semibold">Total: ${{ number_format($totalAmount, 2) }}</p>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
            Place Order
        </button>
    </form>
</div>
@endsection
