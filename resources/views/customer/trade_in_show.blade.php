@extends('layouts.customer.app')
@section('title', $tradeIn->brand . ' ' . $tradeIn->component_type . ' | Trade-In')
@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-4 sm:mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex flex-wrap items-center space-x-2">
            <li><a href="{{ route('trade-in.index') }}" class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded transition-colors">Trade-In</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-gray-700">{{ $tradeIn->brand }} {{ $tradeIn->component_type }}</li>
        </ol>
    </nav>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded mb-6" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $tradeIn->brand }} {{ $tradeIn->component_type }}
                </h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium self-start sm:self-auto
                    {{ match($tradeIn->status) {
                        'Available' => 'bg-green-100 text-green-800',
                        'Pending' => 'bg-yellow-100 text-yellow-800',
                        'Sold' => 'bg-gray-100 text-gray-800',
                        'Removed' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800'
                    } }}">
                    {{ $tradeIn->status }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Image Section -->
<div class="rounded-lg overflow-hidden">
    @if($tradeIn->image_path)
        <div class="bg-gray-50 h-72 sm:h-80 md:h-96 flex items-center justify-center">
            <img src="{{ asset('storage/' . $tradeIn->image_path) }}"
                alt="{{ $tradeIn->brand }} {{ $tradeIn->component_type }}"
                class="max-w-full max-h-full object-contain p-2">
        </div>
    @else
        <div class="flex items-center justify-center bg-gray-100 text-gray-500 h-64 rounded-lg">
            <div class="text-center p-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-2">No Image Available</p>
            </div>
        </div>
    @endif
</div>

                <!-- Details Section -->
                <div class="space-y-5">
                    <div class="flex flex-wrap justify-between">
                        <div class="mb-4 sm:mb-0">
                            <p class="font-semibold text-gray-900">Price</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($tradeIn->pricing, 2) }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Condition</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 text-sm font-medium">
                                {{ $tradeIn->condition }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Component Details</h2>
                        <p class="text-gray-700">{{ $tradeIn->component_details }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-500">Brand</p>
                            <p class="font-medium">{{ $tradeIn->brand }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Listed</p>
                            <p class="font-medium">{{ $tradeIn->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Views</p>
                            <p class="font-medium">{{ $tradeIn->views }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-5 border-t border-gray-200">
                        @if(Auth::check() && Auth::id() == $tradeIn->user_id)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('trade-in.edit', $tradeIn) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-white text-sm font-medium rounded-md transition-colors">
                                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Listing
                                </a>

                                @if($tradeIn->status == 'Available')
                                    <form action="{{ route('trade-in.update-status', $tradeIn) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Sold">
                                        <button type="submit" aria-label="Mark component as sold"
                                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-white text-sm font-medium rounded-md transition-colors">
                                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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
                                        <button type="submit" aria-label="Remove component listing"
                                                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 text-white text-sm font-medium rounded-md transition-colors">
                                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove Listing
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-md">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Interested in this item?</p>
                                        <p class="mt-1">Contact the seller via the platform messaging system.</p>
                                        @if($tradeIn->status == 'Available')
                                            <a href="#" class="mt-3 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-white text-sm font-medium rounded-md transition-colors">
                                                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                Contact Seller
                                            </a>
                                        @endif
                                    </div>
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