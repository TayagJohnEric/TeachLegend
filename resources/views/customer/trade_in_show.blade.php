@extends('layouts.customer.app')
@section('title', 'Trade-In Show')
@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex space-x-2">
            <li><a href="{{ route('trade-in.index') }}" class="text-indigo-600 hover:underline">Trade-In</a></li>
            <li>/</li>
            <li class="text-gray-700">{{ $tradeIn->brand }} {{ $tradeIn->component_type }}</li>
        </ol>
    </nav>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $tradeIn->brand }} {{ $tradeIn->component_type }}
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ match($tradeIn->status) {
                    'Available' => 'bg-green-100 text-green-800',
                    'Pending' => 'bg-yellow-100 text-yellow-800',
                    'Sold' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-200 text-gray-800'
                } }}">
                {{ $tradeIn->status }}
            </span>
        </div>

        <!-- Body -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Image Section -->
            <div>
                @if($tradeIn->image_path)
                    <img src="{{ asset('storage/' . $tradeIn->image_path) }}"
                         alt="{{ $tradeIn->component_type }}"
                         class="rounded-lg shadow object-cover w-full h-72 md:h-full">
                @else
                    <div class="flex items-center justify-center bg-gray-100 text-gray-500 h-72 rounded-lg">
                        No Image Available
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">Component Details</h3>
                    <p class="text-gray-700">{{ $tradeIn->component_details }}</p>
                </div>

                <div>
                    <p><span class="font-semibold">Brand:</span> {{ $tradeIn->brand }}</p>
                </div>

                <div>
                    <p><span class="font-semibold">Condition:</span> 
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-sm">
                            {{ $tradeIn->condition }}
                        </span>
                    </p>
                </div>

                <div>
                    <p><span class="font-semibold">Price:</span> 
                        <span class="text-xl font-bold text-gray-900">${{ number_format($tradeIn->pricing, 2) }}</span>
                    </p>
                </div>

                <div>
                    <p><span class="font-semibold">Listed:</span> {{ $tradeIn->created_at->format('M d, Y') }}</p>
                </div>

                <div>
                    <p><span class="font-semibold">Views:</span> {{ $tradeIn->views }}</p>
                </div>

                <!-- Action Buttons -->
                @if(Auth::check() && Auth::id() == $tradeIn->user_id)
                    <div class="flex flex-wrap gap-3 pt-4">
                        <a href="{{ route('trade-in.edit', $tradeIn) }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">
                            Edit Listing
                        </a>

                        @if($tradeIn->status != 'Removed')
                            <form action="{{ route('trade-in.update-status', $tradeIn) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Removed">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md">
                                    Remove Listing
                                </button>
                            </form>
                        @endif

                        @if($tradeIn->status == 'Available')
                            <form action="{{ route('trade-in.update-status', $tradeIn) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Sold">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
                                    Mark as Sold
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded">
                        Interested in this item? Contact the seller via the platform messaging.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection