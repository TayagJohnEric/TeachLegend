@extends('layouts.customer.app')

@section('title', 'Services')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header section with improved responsive layout -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-9">
        <div class="max-w-2xl">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Our Services</h1>
            <p class="text-gray-400 ">Professional IT support to keep your technology running smoothly.</p>
        </div>
        
        <a href="{{ route('consultations.index') }}" class="mt-2 sm:mt-0">
            <button class="bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-gray-800 text-white font-medium text-sm py-2 px-4 rounded shadow-md transition duration-300 whitespace-nowrap">
                View Consultation
            </button>
        </a>
    </div>
    
    <!-- Services grid with improved responsiveness -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1 flex flex-col h-full">
                <div class="relative">
                    <img src="{{ asset($service['image']) }}" 
                        class="w-full h-48 object-cover object-center" 
                        alt="{{ $service['name'] }}">
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <h5 class="text-xl font-semibold text-gray-900 mb-2">{{ $service['name'] }}</h5>
                    <p class="text-blue-500 font-medium text-sm mb-4 flex-grow">{{ \Illuminate\Support\Str::limit($service['description'], 100, '...') }}</p>
                    <button type="button" 
                        class="book-now-btn w-full bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 text-white font-medium text-sm py-2 px-4 rounded transition duration-200 ease-in-out"
                        data-service="{{ $service['id'] }}"
                        data-service-name="{{ $service['name'] }}"
                        data-service-description="{{ $service['description'] }}">
                        Book Now
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" id="modalBackdrop"></div>
        
        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('customer.services.book') }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center pb-3 border-b">
                        <h5 class="text-lg font-semibold" id="bookingModalLabel">Book Service</h5>
                        <button type="button" class="close-modal text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label for="service_display" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                id="service_display" readonly>
                            <input type="hidden" name="service_type" id="service_type">
                        </div>
                        <div class="mb-4">
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Appointment Date</label>
                            <input type="date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('appointment_date') border-red-500 @enderror" 
                                id="appointment_date" name="appointment_date" required 
                                min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}">
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror" 
                                    id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="bg-white px-4 py-3 sm:px-6 flex flex-wrap justify-end gap-2">
                    <button type="button" 
                            class="close-modal bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium py-2 px-4 rounded-md transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm py-2 px-4 rounded-md transition duration-200">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('bookingModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const bookButtons = document.querySelectorAll('.book-now-btn');
        const closeButtons = document.querySelectorAll('.close-modal');
        
        // Open modal when "Book Now" is clicked
        bookButtons.forEach(button => {
            button.addEventListener('click', function() {
                const serviceId = this.getAttribute('data-service');
                const serviceName = this.getAttribute('data-service-name');
                
                // Populate the service information
                document.getElementById('service_type').value = serviceId;
                document.getElementById('service_display').value = serviceName;
                
                // Show the modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            });
        });
        
        // Close modal functions
        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Re-enable scrolling
        }
        
        // Close modal when clicking close buttons
        closeButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });
        
        // Close modal when clicking outside
        modalBackdrop.addEventListener('click', closeModal);
        
        // Auto-hide toasts after 5 seconds
        const toasts = document.querySelectorAll('.fixed.bottom-4.right-4 > div');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.remove();
            }, 5000);
            
            // Close button handler
            const closeButton = toast.querySelector('button');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    toast.remove();
                });
            }
        });
    });
</script>
@endsection