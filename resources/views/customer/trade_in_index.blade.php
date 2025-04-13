@extends('layouts.customer.app')

@section('title', 'Trade-in Marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Trade-In Components</h1>
        <p class="text-gray-600 mt-1">Buy and sell pre-owned computer components</p>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filters Sidebar -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                    <h2 class="font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </h2>
                </div>
                <div class="p-4">
                    <form action="{{ route('trade-in.index') }}" method="GET">
                        <div class="mb-4">
                            <label for="component_type" class="block text-sm font-medium text-gray-700 mb-1">Component Type</label>
                            <select name="component_type" id="component_type" class=" px-3 py-2 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Types</option>
                                @foreach($componentTypes as $type)
                                    <option value="{{ $type }}" {{ request('component_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                            <select name="brand" id="brand" class="px-3 py-2 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                        {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                            <select name="condition" id="condition" class="px-3 py-2 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Any Condition</option>
                                <option value="Like New" {{ request('condition') == 'Like New' ? 'selected' : '' }}>Like New</option>
                                <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                <option value="Needs Repair" {{ request('condition') == 'Needs Repair' ? 'selected' : '' }}>Needs Repair</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price ($)</label>
                            <input type="number" name="min_price" id="min_price" class="px-3 py-2 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ request('min_price') }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price ($)</label>
                            <input type="number" name="max_price" id="max_price" class="px-3 py-2 w-full bg-gray-50 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ request('max_price') }}">
                        </div>
                        
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white hover:bg-gray-800 font-medium text-sm py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                Apply Filters
                            </button>
                            <a href="{{ route('trade-in.index') }}" class="bg-white hover:bg-gray-300 text-gray-700 border border-gray-300 shadow-sm font-medium text-sm py-2 px-4 rounded-md transition duration-150 ease-in-out text-center">
                                Clear
                            </a>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('trade-in.create') }}" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-emerald-700 text-white text-center font-medium text-sm py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        List Your Component
                    </span>
                </a>
                @auth
                <a href="{{ route('trade-in.my-listings') }}"
                class="block w-full bg-white border border-gray-300 hover:bg-gray-300 text-center py-2 px-4 font-medium text-sm rounded-md transition duration-150 ease-in-out">
                 <span class="flex items-center justify-center">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                     </svg>
                     Your Listings
                 </span>
             </a>
             
                @endauth
            </div>
        </div>
        
        <!-- Listings Grid -->
        <div class="w-full lg:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($listings as $listing)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-150 ease-in-out">
                        @if($listing->image_path)
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                <img src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->component_type }} by {{ $listing->brand }}" class="object-cover w-full h-48">
                            </div>
                        @else
                            <div class="flex items-center justify-center bg-gray-100 h-48">
                                <span class="text-gray-400 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    No Image
                                </span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $listing->brand }} {{ $listing->component_type }}</h3>
                            <p class="text-gray-600 text-sm truncate mb-3">{{ $listing->component_details }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($listing->condition == 'Like New') 
                                        bg-green-100 text-green-800 
                                    @elseif($listing->condition == 'Used') 
                                        bg-blue-100 text-blue-800
                                    @else 
                                        bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $listing->condition }}
                                </span>
                                <span class="font-bold text-gray-900">${{ number_format($listing->pricing, 2) }}</span>
                            </div>
                            <a href="{{ route('trade-in.show', $listing) }}" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-indigo-700 text-white text-center text-sm font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                View Details
                            </a>
                        </div>
                        <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500">
                            <div class="flex justify-between">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $listing->views }}
                                </span>
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $listing->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-blue-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-blue-800 font-medium">No trade-in listings found matching your criteria.</p>
                        <p class="text-blue-600 mt-2">Try adjusting your filters or check back later for new listings.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection