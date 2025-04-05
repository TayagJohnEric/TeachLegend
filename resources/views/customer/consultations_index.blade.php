@extends('layouts.customer.app')

@section('title', 'Consultation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header with gradient background -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex flex-col sm:flex-row justify-between items-center">
            <h1 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-0">My Consultation Requests</h1>
            <button id="openConsultationModal" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 font-medium rounded-md shadow hover:bg-blue-700 transition-colors duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                New Request
            </button>
            
        </div>
        
        <div class="p-6">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responses</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($consultationRequests as $request)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $request->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 line-clamp-2">{{ Str::limit($request->request_details, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ 
                                        $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                        ($request->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))
                                    }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        {{ $request->responses->count() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $request->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('consultations.show', $request->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-md transition-colors duration-150 ease-in-out">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="font-medium">No consultation requests found</p>
                                        <p class="mt-1">Create your first consultation request to get started</p>
                                        <a href="{{ route('consultations.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md shadow hover:bg-blue-700 transition-colors duration-150 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Create New Request
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Consultation Request Modal -->
<div id="consultationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Modal backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" id="modalBackdrop"></div>
    
    <!-- Modal content -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
            <!-- Modal header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-lg">
                <div class="flex items-center justify-between px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Submit New Consultation Request</h3>
                    <button type="button" id="closeModalBtn" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
           <!-- Modal body -->
<div class="p-6">
    <form id="consultationForm" method="POST" action="{{ route('consultations.store') }}">
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
        
        <div class="mt-6 flex items-center justify-end space-x-3">
            <button type="button" id="cancelModal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Submit Request
            </button>
        </div>
    </form>
</div>
</div>

<!-- JavaScript for Modal Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('consultationModal');
        const openModalBtn = document.getElementById('openConsultationModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelModal = document.getElementById('cancelModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        
        // Function to open modal
        function openModal() {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        // Function to close modal
        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            // Reset form if needed
            document.getElementById('consultationForm').reset();
        }
        
        // Event listeners
        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelModal.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
    });
</script>



@endsection