@extends('layouts.customer.app')

@section('title', 'PC Build Details')

@section('content')
<div class="container mx-auto px-6 py-3 max-w-5xl">
    <div class="bg-white shadow-sm rounded-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-white px-6 py-4 border-b-2 border-gray-50">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800">PC Build Details</h1>
                <a href="{{ route('pc-builder.list') }}" class="flex items-center border border-gray-200 text-gray-700 text-sm px-4 py-3 bg-white font-medium rounded-lg transition-colors duration-200 hover:border-gray-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <!-- Build Information -->
            <div class="mb-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                        <p class="font-bold text-blue-600 ">${{ number_format($pcBuild->budget, 2) }}</p>
                        <p class="text-sm text-gray-500">Budget</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:border-gray-300 transition ">
                        <p class="font-bold text-green-600">${{ number_format($pcBuild->total_cost, 2) }}</p>
                        <p class="text-sm text-gray-500">Total Cost</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 hover:border-gray-300">
                        <p class="font-bold">{{ $pcBuild->created_at->format('d M, Y') }}</p>
                        <p class="text-sm text-gray-500">Created</p>
                    </div>
                </div>
            </div>

            <!-- Selected Components -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 border-b-2 border-gray-50 pb-2 mb-4">Selected Components</h2>
                
                @if($selectedProducts->isEmpty())
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-500">No components selected for this build.</p>
                    </div>
                @else
                    <!-- Desktop view (2-3 columns grid) -->
                    <div class="hidden sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($selectedProducts as $product)
                            <div class="bg-white border-2 border-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                <div class="h-40 bg-white flex items-center justify-center p-4">
                                    <img 
                                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                        alt="{{ $product->name }}"
                                        class="max-h-32 max-w-full object-contain"
                                    />
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                    <p class="text-green-600 font-semibold mt-1">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Mobile view (horizontal layout) -->
                    <div class="grid grid-cols-1 gap-4 sm:hidden">
                        @foreach($selectedProducts as $product)
                            <div class="bg-white border-2 border-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                <div class="flex">
                                    <div class="w-1/3 bg-white flex items-center justify-center p-2">
                                        <img 
                                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                            alt="{{ $product->name }}"
                                            class="max-h-20 max-w-full object-contain"
                                        />
                                    </div>
                                    <div class="w-2/3 p-4 flex flex-col justify-center">
                                        <h3 class="font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                        <p class="text-green-600 font-semibold mt-1">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-gray-200">
                <div class="flex gap-2">
                    <form action="{{ route('pc-builder.destroy', $pcBuild->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this build?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center px-4 py-3 font-medium text-sm text-gray-500 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete Build
                        </button>
                    </form>
                </div>
                
                <a href="{{ route('customer.checkout', ['pc_build_id' => $pcBuild->id]) }}" 
                    class="flex items-center px-4 py-3 bg-gradient-to-r  text-sm from-blue-600 to-indigo-800 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Proceed to Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection