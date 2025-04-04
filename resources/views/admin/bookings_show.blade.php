@extends('layouts.admin.app')

@section('title', 'Bookings Details')

@section('content')
<!-- resources/views/admin/bookings/show.blade.php -->

<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-3 md:mb-0">Booking Details</h2>
        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
            Back to Bookings
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Booking Information Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-700">Booking Information</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="mb-2"><span class="font-medium">Booking ID:</span> {{ $booking->id }}</p>
                            <p class="mb-2"><span class="font-medium">Service Type:</span> {{ $booking->service_type }}</p>
                            <p class="mb-2"><span class="font-medium">Appointment Date:</span> {{ $booking->appointment_date }}</p>
                            <p class="mb-2">
                                <span class="font-medium">Status:</span> 
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $booking->status == 'in_progress' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="mb-2"><span class="font-medium">Customer:</span> {{ $booking->user->first_name }} {{ $booking->user->last_name }}</p>
                            <p class="mb-2"><span class="font-medium">Customer Email:</span> {{ $booking->user->email }}</p>
                            <p class="mb-2"><span class="font-medium">Customer Phone:</span> {{ $booking->user->phone_number ?? 'N/A' }}</p>
                            <p class="mb-2"><span class="font-medium">Created On:</span> {{ $booking->created_at }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 border-t pt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Notes:</h4>
                        <p class="text-gray-600">{{ $booking->notes ?? 'No notes available' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <!-- Assigned Technician Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-700">Assigned Technician</h3>
                </div>
                <div class="p-4">
                    @if($booking->technician)
                        <p class="mb-2"><span class="font-medium">Name:</span> {{ $booking->technician->first_name }} {{ $booking->technician->last_name }}</p>
                        <p class="mb-2"><span class="font-medium">Email:</span> {{ $booking->technician->email }}</p>
                        <p class="mb-2"><span class="font-medium">Phone:</span> {{ $booking->technician->phone_number ?? 'N/A' }}</p>
                    @else
                        <p class="text-gray-600">No technician assigned yet.</p>
                    @endif
                </div>
            </div>

            <!-- Management Actions Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-700">Management Actions</h3>
                </div>
                <div class="p-4">
                    <!-- Assign Technician Form -->
                    @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.assign', $booking->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Technician:</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        id="technician_id" name="technician_id" required>
                                    <option value="">Select Technician</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}">
                                            {{ $technician->first_name }} {{ $technician->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                                Assign & Approve
                            </button>
                        </form>
                    @endif

                    <!-- Update Status Form -->
                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status:</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                    id="status" name="status" required>
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            Update Status
                        </button>
                    </form>

                    <!-- Cancel Booking Button -->
                    @if($booking->status != 'cancelled')
                        <button type="button" class="w-full py-2 px-4 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition mb-3"
                                onclick="openModal('cancelModal')">
                            Cancel Booking
                        </button>
                    @endif

                    <!-- Archive Booking Button -->
                    <button type="button" class="w-full py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                            onclick="openModal('deleteModal')">
                        Archive Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Cancellation</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('cancelModal')">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-gray-700">Are you sure you want to cancel this booking?</p>
        </div>
        <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition"
                    onclick="closeModal('cancelModal')">
                Close
            </button>
            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                    Confirm Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Archive</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('deleteModal')">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="px-6 py-4">
            <p class="text-gray-700">Are you sure you want to archive this booking? It will be soft deleted.</p>
        </div>
        <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition"
                    onclick="closeModal('deleteModal')">
                Close
            </button>
            <form action="{{ route('admin.bookings.delete', $booking->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    Confirm Archive
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        // Prevent scrolling of the body when modal is open
        document.body.style.overflow = 'hidden';
        
        // Add escape key listener
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal(modalId);
            }
        });
        
        // Add click outside listener
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal(modalId);
            }
        });
    }
    
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        // Re-enable scrolling
        document.body.style.overflow = '';
    }
</script>
@endsection