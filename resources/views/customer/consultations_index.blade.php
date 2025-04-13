@extends('layouts.customer.app')

@section('title', 'Consultation')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-7xl">
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
    
    <!-- Error Alert -->
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
    
  <!-- Page Header and Action Button Container -->
<div class="flex justify-between items-center mb-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">My Consultation Requests</h1>
        <p class="text-gray-600 mt-1">Manage and track all your consultation requests in one place</p>
    </div>
    
    <!-- Action Button -->
    <button id="openConsultationModal" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create New Request
    </button>
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
            @if(count($consultationRequests) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responses</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Created</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($consultationRequests as $request)
                            <tr class="hover:bg-gray-50">
                                <!-- ID -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $request->id }}</div>
                                </td>
                                
                                <!-- Details -->
                                <td class="px-4 py-4">
                                    <div class="text-sm text-gray-900 line-clamp-2">{{ Str::limit($request->request_details, 50) }}</div>
                                </td>
                                
                                <!-- Status -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $statusColor = 'gray';
                                        if($request->status == 'pending') $statusColor = 'yellow';
                                        elseif($request->status == 'in_progress') $statusColor = 'blue';
                                        elseif($request->status == 'resolved') $statusColor = 'green';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                
                                <!-- Responses -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        {{ $request->responses->count() }}
                                    </div>
                                </td>
                                
                                <!-- Created Date (hidden on mobile) -->
                                <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $request->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                
                                <!-- Actions -->
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- View button -->
                                        <a href="{{ route('consultations.show', $request->id) }}" class="text-blue-600 hover:text-blue-900" aria-label="View consultation details">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No consultation requests yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first consultation request.</p>
                    <button id="emptyStateCreateBtn" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Request
                    </button>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if(count($consultationRequests) > 0)
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                <div class="flex justify-center">
                    {{ $consultationRequests->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Consultation Request Modal -->
<div id="consultationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-start justify-center pt-12 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center text-blue-600">
                    <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Submit New Consultation Request</h3>
                </div>
                <button onclick="closeConsultationModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="consultationForm" method="POST" action="{{ route('consultations.store') }}" class="mt-4">
                @csrf
                
                <div class="mb-4">
                    <label for="request_details" class="block text-sm font-medium text-gray-700 mb-1">Request Details</label>
                    <textarea 
                        name="request_details" 
                        id="request_details" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('request_details') border-red-500 @enderror" 
                        rows="5" 
                        required
                    >{{ old('request_details') }}</textarea>
                    
                    @error('request_details')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeConsultationModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Control -->
<script>
    function openConsultationModal() {
        // Show the modal
        document.getElementById('consultationModal').classList.remove('hidden');
    }
    
    function closeConsultationModal() {
        // Hide the modal
        document.getElementById('consultationModal').classList.add('hidden');
        // Reset form if needed
        document.getElementById('consultationForm').reset();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Set up event listeners
        document.getElementById('openConsultationModal').addEventListener('click', openConsultationModal);
        
        // For the empty state create button (if it exists)
        const emptyStateBtn = document.getElementById('emptyStateCreateBtn');
        if (emptyStateBtn) {
            emptyStateBtn.addEventListener('click', openConsultationModal);
        }
        
        // Close modal if user clicks outside of it
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('consultationModal');
            if (event.target === modal) {
                closeConsultationModal();
            }
        });
        
        // Close modal on escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('consultationModal').classList.contains('hidden')) {
                closeConsultationModal();
            }
        });
    });
</script>
@endsection