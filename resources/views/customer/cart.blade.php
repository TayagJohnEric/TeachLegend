@extends('layouts.customer.app')

@section('title', "Shopping Cart")

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Cart Header & Total Products in One Box --}}
    <div class="bg-white py-4 px-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Your Shopping Cart</h2>
        <div class="text-lg font-semibold text-gray-800 mt-2 md:mt-0">
            Total Products: <span class="text-xl font-bold">{{ $cartItems->sum('quantity') }}</span>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <div class="bg-white border border-gray-100 shadow-2xl rounded-xl p-10 text-center max-w-md mx-auto">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-xl text-gray-600 mb-6">Your cart is currently empty</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                Explore Products
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($cartItems as $item)
                <div class="bg-white border border-gray-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 group">
                    <div class="p-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        {{-- Product Image --}}
                        <div class="md:col-span-2 flex justify-center">
                            <div class="w-24 h-24 rounded-lg overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{-- Product Details --}}
                        <div class="md:col-span-4 space-y-2">
                            <a href="{{ route('products.show', $item->product->id) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-gray-500 text-sm">Unit Price: ${{ number_format($item->product->price, 2) }}</p>
                        </div>

{{-- Quantity Control --}}
<div class="md:col-span-2 flex flex-col items-center justify-center">
    <label for="quantity{{ $item->id }}" class="text-gray-700 text-sm font-semibold mb-1">Quantity:</label>
    <input type="number" name="quantity" id="quantity{{ $item->id }}" 
           value="{{ $item->quantity }}" 
           min="1" max="{{ $item->product->stock }}" 
           class="update-quantity w-16 text-center text-gray-700 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
           data-id="{{ $item->id }}">
</div>


                     <!-- Total Price -->
<div class="md:col-span-2 text-center">
    <label class="block text-sm font-medium text-gray-700">Total Price:</label>
    <span class="text-lg font-bold text-gray-900">
        ${{ number_format($item->product->price * $item->quantity, 2) }}
    </span>
</div>


                        {{-- Remove Button --}}
                        <div class="md:col-span-2 flex justify-center space-x-4">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" 
                                  onsubmit="return confirm('Are you sure you want to remove this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-gray-600  transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if(!$cartItems->isEmpty())
        <div class="mt-8 flex justify-end">
            <a href="{{ route('customer.checkout') }}" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-800 hover: text-white font-bold py-3 px-8 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg hover:shadow-xl">
                Proceed to Checkout
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.update-quantity').on('change', function() {
            let cartId = $(this).data('id');
            let quantity = $(this).val();

            $.ajax({
                url: "{{ url('/cart/update') }}/" + cartId,
                type: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    quantity: quantity
                },
                success: function(response) {
                    location.reload(); // Refresh the page to reflect changes
                },
                error: function(response) {
                    alert("Failed to update quantity. Please try again.");
                }
            });
        });
    });
</script>
@endsection
