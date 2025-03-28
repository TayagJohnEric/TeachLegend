@extends('layouts.customer.app')

@section('title', 'Your Orders')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Your Orders</h2>

    @if($orders->isEmpty())
        <div class="bg-white shadow-lg rounded-lg p-8 text-center">
            <p class="text-xl text-gray-600 mb-6">You have not placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-200">
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                        <div class="text-sm font-medium px-4 py-2 rounded-lg
                            @if($order->order_status == 'pending') bg-yellow-200 text-yellow-800
                            @elseif($order->order_status == 'processing') bg-blue-200 text-blue-800
                            @elseif($order->order_status == 'completed') bg-green-200 text-green-800
                            @elseif($order->order_status == 'cancelled') bg-red-200 text-red-800
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-gray-700"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                        <p class="text-gray-700"><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>

                    <h4 class="text-md font-semibold text-gray-800 mb-3">Order Items:</h4>
                    <ul class="space-y-3">
                        @foreach($order->orderItems as $item)
                            <li class="flex justify-between items-center border-b py-2">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                    <a href="{{ route('products.show', $item->product->id) }}" class="ml-4 text-gray-900 font-medium hover:text-blue-600">
                                        {{ $item->product->name }}
                                    </a>
                                </div>
                                <div class="text-gray-700">
                                    <span class="font-medium">₱{{ number_format($item->price_at_purchase, 2) }}</span> x {{ $item->quantity }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
