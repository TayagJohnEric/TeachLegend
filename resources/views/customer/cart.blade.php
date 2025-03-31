@extends('layouts.customer.app')

@section('title', "Shopping Cart")

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-0">

    {{-- Cart Header & Total Products in One Box --}}
    <div class="bg-white py-3 px-4 sm:py-4 sm:px-6 rounded-lg shadow-sm flex flex-col sm:flex-row justify-between items-center mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-700">Your Shopping Cart</h2>
        <div class="text-sm sm:text-md font-medium text-gray-500 mt-2 sm:mt-0">
            Total Products: <span class="text-base sm:text-lg font-medium">{{ $cartItems->sum('quantity') }}</span>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <div class="p-6 sm:p-10 text-center max-w-md mx-auto">
            <div class="mb-4 sm:mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 sm:h-24 w-16 sm:w-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-base sm:text-lg text-gray-400 mb-4 sm:mb-6">Your cart is currently empty</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                Explore Products
            </a>
        </div>
    @else
        <div class="space-y-4 sm:space-y-6">
            @foreach($cartItems as $item)
                <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group relative">
                    {{-- Mobile Delete Button (Top Right) --}}
                    <div class="absolute top-2 right-2 block sm:hidden">
                        <form method="POST" action="{{ route('cart.remove', $item->id) }}" 
                              onsubmit="return confirm('Are you sure you want to remove this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-600 transition-colors p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="p-4 sm:p-6 grid grid-cols-12 gap-2 sm:gap-6 items-center">
                        {{-- Product Image --}}
                        <div class="col-span-3 sm:col-span-2 flex justify-center">
                            <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-lg overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{-- Product Details --}}
                        <div class="col-span-9 sm:col-span-4 space-y-1 sm:space-y-2">
                            <a href="{{ route('products.show', $item->product->id) }}" class="text-base sm:text-lg font-semibold text-gray-700 hover:text-blue-600 transition-colors">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-xs sm:text-sm text-gray-500">Unit Price: ${{ number_format($item->product->price, 2) }}</p>
                        </div>

                        {{-- Quantity Control --}}
                        <div class="col-span-6 sm:col-span-2 flex flex-col items-center justify-center">
                            <label for="quantity{{ $item->id }}" class="text-xs sm:text-sm text-gray-500 font-semibold mb-1">Quantity:</label>
                            <input type="number" name="quantity" id="quantity{{ $item->id }}" 
                                value="{{ $item->quantity }}" 
                                min="1" max="{{ $item->product->stock }}" 
                                class="update-quantity w-14 sm:w-16 text-center text-gray-700 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                data-id="{{ $item->id }}">
                        </div>

                        <!-- Total Price -->
                        <div class="col-span-6 sm:col-span-2 text-center">
                            <label class="block text-xs sm:text-sm font-medium text-gray-500">Total:</label>
                            <span class="text-base sm:text-lg font-bold text-gray-700">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </span>
                        </div>

                        {{-- Desktop Delete Button --}}
                        <div class="hidden sm:flex sm:col-span-2 justify-center space-x-4">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" 
                                onsubmit="return confirm('Are you sure you want to remove this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
        <div class="mt-6 sm:mt-8 flex justify-center sm:justify-end">
            <a href="{{ route('customer.checkout') }}" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-800 text-white font-bold py-2 px-6 sm:py-3 sm:px-8 rounded-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 shadow-lg hover:shadow-xl text-sm sm:text-base">
                Proceed to Checkout
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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