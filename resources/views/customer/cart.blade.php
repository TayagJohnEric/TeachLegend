@extends('layouts.customer.app')

@section('title', "Shopping Cart")

@section('content')
<div class="container mx-auto px-2 py-8 sm:px-4 py-8">

    {{-- Cart Header & Total Products in One Box --}}
    <div class="bg-white shadow-sm py-3 px-4 sm:py-3 sm:px-6 rounded-lg flex flex-col sm:flex-row justify-between items-center mb-5 sm:mb-5">
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
                <button form="remove-form-{{ $item->id }}" type="submit" 
                        class="absolute top-2 right-2 block sm:hidden text-gray-500 hover:text-red-500 transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
    
                <div class="p-3 sm:p-6">
                    <div class="grid grid-cols-12 gap-2 sm:gap-6 items-center">
                        {{-- Product Image --}}
                        <div class="col-span-4 sm:col-span-2 flex justify-center">
                            <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-lg overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
    
                        {{-- Product Details --}}
                        <div class="col-span-8 sm:col-span-4 space-y-1">
                            <a href="{{ route('products.show', $item->product->id) }}" class="text-sm sm:text-lg font-semibold text-gray-700 hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-xs sm:text-sm text-gray-500">Unit: ${{ number_format($item->product->price, 2) }}</p>
                        </div>
    
                        {{-- Mobile Layout: Quantity & Total in one row --}}
                        <div class="col-span-12 grid grid-cols-2 gap-2 mt-3 sm:hidden">
                            {{-- Quantity Control --}}
                            <div class="flex items-center justify-start">
                                <label for="quantity{{ $item->id }}" class="text-xs text-gray-500 font-medium mr-2">Qty:</label>
                                <input type="number" name="quantity" id="quantity{{ $item->id }}" 
                                    value="{{ $item->quantity }}" 
                                    min="1" max="{{ $item->product->stock }}" 
                                    class="update-quantity w-14 text-center text-gray-700 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    data-id="{{ $item->id }}">
                            </div>
    
                            {{-- Total Price --}}
                            <div class="flex items-center justify-end">
                                <span class="text-xs text-gray-500 font-medium mr-2">Total:</span>
                                <span class="text-sm font-bold text-gray-700">
                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </span>
                            </div>
                        </div>
    
                        {{-- Desktop Layout: Separate Quantity & Total --}}
                        <div class="hidden sm:block sm:col-span-2 text-center">
                            <label for="quantity{{ $item->id }}" class="block text-xs sm:text-sm text-gray-500 font-medium mb-1">Quantity:</label>
                            <input type="number" name="quantity" id="quantity{{ $item->id }}" 
                                value="{{ $item->quantity }}" 
                                min="1" max="{{ $item->product->stock }}" 
                                class="update-quantity w-16 text-center text-gray-700 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                data-id="{{ $item->id }}">
                        </div>
    
                        <div class="hidden sm:block sm:col-span-2 text-center">
                            <label class="block text-xs sm:text-sm font-medium text-gray-500">Total:</label>
                            <span class="text-base sm:text-lg font-bold text-gray-700">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </span>
                        </div>
    
                        {{-- Desktop Delete Button --}}
                        <div class="hidden sm:flex sm:col-span-2 justify-center">
                            <button form="remove-form-{{ $item->id }}" type="submit" 
                                    class="bg-gray-50 text-gray-500 px-3 py-2 rounded-md hover:bg-red-50 hover:text-red-500 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
    
                {{-- Hidden Remove Form --}}
                <form id="remove-form-{{ $item->id }}" method="POST" action="{{ route('cart.remove', $item->id) }}" 
                      onsubmit="return confirm('Are you sure you want to remove this item?');" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
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