@extends('layouts.customer.app')
@section('title', 'My Listings')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-2xl font-bold text-gray-800">Your Trade-In Listings</h1>
    </div>
    
    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between gap-3 mb-6">
        <button onclick="window.location='{{ route('trade-in.index') }}'" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to All Listings
        </button>
        <a href="{{ route('trade-in.create') }}" 
   class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Create New Listing
</a>
    </div>
    
    <!-- Listings Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Card Header for mobile filtering options (can be expanded) -->
        <div class="p-4 border-b border-gray-200 sm:hidden">
            <button type="button" class="text-sm text-gray-600 flex items-center" id="mobile-filter-button">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter & Sort
            </button>
        </div>
        
        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            @if(count($listings) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Condition</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Views</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Listed</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($listings as $listing)
                            <tr class="hover:bg-gray-50">
                                <!-- Component Info -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($listing->image_path)
                                            <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $listing->image_path) }}" alt="{{ $listing->brand }} {{ $listing->component_type }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-md flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $listing->brand }} {{ $listing->component_type }}</div>
                                            <div class="text-xs text-gray-500 truncate max-w-xs">{{ $listing->component_details }}</div>
                                            <!-- Mobile-only condition badge -->
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 sm:hidden mt-1">
                                                {{ $listing->condition }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Price -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($listing->pricing, 2) }}</div>
                                </td>
                                
                                <!-- Condition (hidden on mobile) -->
                                <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $listing->condition }}
                                    </span>
                                </td>
                                
                                <!-- Status -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $statusColor = 'gray';
                                        if($listing->status == 'Available') $statusColor = 'green';
                                        elseif($listing->status == 'Pending') $statusColor = 'yellow';
                                        elseif($listing->status == 'Sold') $statusColor = 'red';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        {{ $listing->status }}
                                    </span>
                                </td>
                                
                                <!-- Views (hidden on mobile) -->
                                <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-gray-500">{{ $listing->views }}</div>
                                </td>
                                
                                <!-- Listed Date (hidden on mobile) -->
                                <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-gray-500">{{ $listing->created_at->format('M d, Y') }}</div>
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- View button -->
                                        <a href="{{ route('trade-in.show', $listing) }}" class="text-gray-500 hover:text-gray-600" aria-label="View listing details">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        <!-- Edit button -->
                                        <a href="{{ route('trade-in.edit', $listing) }}" class="text-gray-500 hover:text-gray-600" aria-label="View listing details">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                        </a>
                                        

                                        <!-- Delete button (with modal) -->  
                                        <button type="button" 
                                                onclick="openDeleteModal({{ $listing->id }}, '{{ $listing->brand }} {{ $listing->component_type }}')" 
                                                class="text-gray-500 hover:text-gray-600" 
                                                aria-label="Delete listing">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <!-- Empty State -->
                <div class="py-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No listings yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first trade-in listing.</p>
                   
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if(count($listings) > 0)
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                <div class="flex justify-center">
                    {{ $listings->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-start justify-center pt-12 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center text-red-600">
                    <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Delete Confirmation</h3>
                </div>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500">Are you sure you want to delete <span id="deleteItemName" class="font-medium"></span>? This action cannot be undone.</p>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


   

<!-- JavaScript for Modal Control -->
<script>
    function openDeleteModal(listingId, listingName) {
        // Set the form action
        document.getElementById('deleteForm').action = "{{ route('trade-in.destroy', '') }}/" + listingId;
        
        // Set the item name in the confirmation message
        document.getElementById('deleteItemName').textContent = listingName;
        
        // Show the modal
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        // Hide the modal
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Close modal if user clicks outside of it
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    });
    
    // Close modal on escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
@endsection