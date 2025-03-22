@extends('layouts.customer.app')

@section('title', "Shopping Cart")

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Your Shopping Cart</h2>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Continue Shopping
        </a>
    </div>

    @if($cartItems->isEmpty())
        <div class="bg-white shadow-lg rounded-lg p-8 text-center">
            <p class="text-xl text-gray-600 mb-6">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Discover Products
            </a>
        </div>
    @else
        <div class="mb-4 text-lg font-semibold text-gray-800">
            Total Products: {{ $cartItems->sum('quantity') }}
        </div>
        <div class="space-y-4">
            @foreach($cartItems as $item)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition duration-200">
                    <div class="p-4 md:p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex flex-col md:flex-row md:items-center flex-1 gap-4 mb-4 md:mb-0">
                            <div class="w-20 h-20 flex-shrink-0 rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <a href="{{ route('products.show', $item->product->id) }}" class="text-lg font-medium text-gray-900 hover:text-blue-600">
                                {{ $item->product->name }}
                            </a>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-8 w-full md:w-auto">
                            <div class="text-sm md:text-base text-gray-700">
                                <span class="md:hidden font-medium">Price: </span>
                                ${{ number_format($item->product->price, 2) }}
                            </div>
                            <div class="text-sm md:text-base text-gray-700">
                                <span class="md:hidden font-medium">Quantity: </span>
                                {{ $item->quantity }}
                            </div>
                            <div class="text-sm md:text-base font-medium text-gray-900">
                                <span class="md:hidden font-medium">Total: </span>
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </div>
                            <div>
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 flex items-center">
                                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if(!$cartItems->isEmpty())
    <div class="mt-6">
        <a href="{{ route('checkout.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
            Proceed to Checkout
        </a>
    </div>
@endif
</div>
@endsection