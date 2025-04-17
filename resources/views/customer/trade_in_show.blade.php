@extends('layouts.customer.app')
@section('title', $tradeIn->brand . ' ' . $tradeIn->component_type . ' | Trade-In')
@section('content')

<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm mb-6 text-gray-500" aria-label="Breadcrumb">
        <ol class="flex items-center flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('trade-in.index') }}" class="hover:text-blue-600 transition-colors">Trade-In</a>
            </li>
            <li class="mx-2">/</li>
            <li class="text-gray-700 font-medium truncate">{{ $tradeIn->brand }} {{ $tradeIn->component_type }}</li>
        </ol>
    </nav>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $tradeIn->brand }} {{ $tradeIn->component_type }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $tradeIn->status == 'Available' ? 'bg-green-100 text-green-800' : 
                    ($tradeIn->status == 'Sold' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                    {{ $tradeIn->status }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Image Section -->
                <div class="flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                    @if($tradeIn->image_path)
                        <div class="w-full aspect-square">
                            <img src="{{ asset('storage/' . $tradeIn->image_path) }}"
                                alt="{{ $tradeIn->brand }} {{ $tradeIn->component_type }}"
                                class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="text-center py-12 px-6">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No Image Available</p>
                        </div>
                    @endif
                </div>

                <!-- Details Section -->
                <div class="flex flex-col space-y-6">
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Price</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($tradeIn->pricing, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Condition</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium
                                {{ $tradeIn->condition == 'New' ? 'bg-green-100 text-green-800' : 
                                ($tradeIn->condition == 'Like New' ? 'bg-blue-100 text-blue-800' : 
                                ($tradeIn->condition == 'Good' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $tradeIn->condition }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-medium text-gray-900 mb-2">Component Details</h2>
                        <div class="prose max-w-none text-gray-700">
                            <p>{{ $tradeIn->component_details }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-sm border-t border-gray-200 pt-4">
                        <div>
                            <p class="text-gray-500 mb-1">Brand</p>
                            <p class="font-medium text-gray-900">{{ $tradeIn->brand }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Listed</p>
                            <p class="font-medium text-gray-900">{{ $tradeIn->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Views</p>
                            <div class="flex">
                            <svg class="h-4 w-4 mr-1 text-gray-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="font-medium text-gray-900">{{ $tradeIn->views }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        @if(Auth::check() && Auth::id() == $tradeIn->user_id)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('trade-in.edit', $tradeIn) }}" 
                                class="inline-flex items-center px-4 py-2 border border-gray-900 text-sm font-medium rounded text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                 <svg class="h-4 w-4 mr-1 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                     <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                 </svg>
                                 Edit Listing
                             </a>

                                @if($tradeIn->status == 'Available')
                                    <form action="{{ route('trade-in.update-status', $tradeIn) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Sold">
                                        <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="h-4 w-4 mr-1 text-green-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Mark as Sold
                                </button>
                                    </form>
                                @endif

                                @if($tradeIn->status != 'Removed')
                                    <form action="{{ route('trade-in.update-status', $tradeIn) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Removed">
                                        <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded text-gray-700 bg-white hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="h-4 w-4 mr-1 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Remove
                                </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-center sm:text-left">
                                    <p class="text-base font-medium text-gray-900">Interested in this item?</p>
                                    <p class="text-sm text-gray-500 mb-3">Contact the seller via the platform messaging system.</p>
                                    @if($tradeIn->status == 'Available')
                                        <a href="#" 
                                           class="inline-flex justify-center w-full sm:w-auto items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            Contact Seller
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection