@extends('layouts.admin.app')

@section('title', 'Booking Details')

@section('content')
<div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-2">
            <h2 class="text-2xl font-bold text-gray-900">Booking Details</h2>
            <a href="{{ route('admin.bookings.index') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-200 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Bookings
            </a>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Booking and Customer Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Information Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Booking Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Service Type</p>
                                </div>
                                <p class="text-base font-medium text-gray-900">{{ $booking->service_type }}</p>
                            </div>

                            <div>
                                <div class="flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Appointment Date</p>
                                </div>
                                <p class="text-base font-medium text-gray-900">{{ $booking->appointment_date }}</p>
                            </div>

                            <div>
                                <div class="flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Status</p>
                                </div>
                                <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $booking->status == 'in_progress' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </p>
                            </div>

                            <div>
                                <div class="flex items-center mb-3">
                                    <svg class="h-5 w-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Created On</p>
                                </div>
                                <p class="text-base font-medium text-gray-900">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="font-medium text-gray-900 mb-3">Notes:</h4>
                            <div class="bg-gray-50 rounded-md p-4">
                                <p class="text-gray-700">{{ $booking->notes ?? 'No notes available' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Profile Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Customer Profile</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 text-xl font-bold">
                                @if($booking->user->profile)
                                    <img src="{{ asset('storage/' . $booking->user->profile) }}" alt="Customer Profile" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    {{ substr($booking->user->first_name, 0, 1) }}{{ substr($booking->user->last_name, 0, 1) }}
                                @endif
                            </div>
                            <div class="ml-6">
                                <h4 class="text-xl font-medium text-gray-900">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</h4>
                                <p class="text-sm text-gray-500">Customer</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="flex items-center mb-2">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-gray-500">Email</span>
                                </div>
                                <p class="text-gray-900">{{ $booking->user->email }}</p>
                            </div>
                            <div>
                                <div class="flex items-center mb-2">
                                    <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm text-gray-500">Phone</span>
                                </div>
                                <p class="text-gray-900">{{ $booking->user->phone_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Technician and Actions -->
            <div class="space-y-6">
                <!-- Assigned Technician Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Assigned Technician</h3>
                    </div>
                    <div class="p-6">
                        @if($booking->technician)
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-14 w-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-lg font-bold">
                                    @if($booking->technician->profile)
                                        <img src="{{ asset('storage/' . $booking->technician->profile) }}" alt="Technician Profile" class="h-14 w-14 rounded-full object-cover">
                                    @else
                                        {{ substr($booking->technician->first_name, 0, 1) }}{{ substr($booking->technician->last_name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $booking->technician->first_name }} {{ $booking->technician->last_name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $booking->technician->email }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <p class="text-gray-900">{{ $booking->technician->phone_number ?? 'N/A' }}</p>
                            </div>
                        @else
                            <div class="py-4 flex justify-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No technician assigned yet.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Management Actions Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Management Actions</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($booking->status == 'pending')
                            <button type="button" onclick="openModal('technicianModal')" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Assign Technician
                            </button>
                        @endif

                        <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Status:</label>
                                <select id="status" name="status" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base shadow-sm border border-gray-200 font-medium text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Update Status
                            </button>
                        </form>

                        <div class="border-t border-gray-200 pt-4 flex flex-col space-y-3">
                            @if($booking->status != 'cancelled')
                                <button type="button" onclick="openModal('cancelModal')" class="flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="h-5 w-5 mr-2 text-gray-600 text-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel Booking
                                </button>
                            @endif

                            <button type="button" onclick="openModal('deleteModal')" class="flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="h-5 w-5 mr-2 text-gray-600 text-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Archive Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Technician Assignment Modal -->
<div id="technicianModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Select Technician</h3>
                <button type="button" onclick="closeModal('technicianModal')" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-5 max-h-96 overflow-y-auto">
                <div class="divide-y divide-gray-200">
                    @foreach($technicians as $technician)
                        <div class="py-4">
                            <form action="{{ route('admin.bookings.assign', $booking->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="technician_id" value="{{ $technician->id }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 text-lg font-bold">
                                            @if($technician->profile)
                                                <img src="{{ asset('storage/' . $technician->profile) }}" alt="Technician Profile" class="h-12 w-12 rounded-full object-cover">
                                            @else
                                                {{ substr($technician->first_name, 0, 1) }}{{ substr($technician->last_name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $technician->first_name }} {{ $technician->last_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $technician->email }}</p>
                                        </div>
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Assign
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" onclick="closeModal('technicianModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Confirm Cancellation</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Are you sure you want to cancel this booking? This action cannot be undone.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="sm:ml-3">
                @csrf
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                    Confirm Cancel
                </button>
            </form>
            <button type="button" onclick="closeModal('cancelModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Delete Modal (continued) -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Confirm Archive</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Are you sure you want to archive this booking? The record will be soft deleted and can be recovered later if needed.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <form action="{{ route('admin.bookings.delete', $booking->id) }}" method="POST" class="sm:ml-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                    Confirm Archive
                </button>
            </form>
            <button type="button" onclick="closeModal('deleteModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    // Improved modal functionality with animations and keyboard/click handling
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        
        // Prevent body scrolling when modal is open
        document.body.style.overflow = 'hidden';
        
        // Show modal with fade-in effect
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Add opacity transition
        setTimeout(() => {
            modal.querySelector('div:first-child').classList.add('ease-out', 'duration-300', 'opacity-100', 'scale-100');
            modal.querySelector('div:first-child').classList.remove('opacity-0', 'scale-95');
        }, 10);
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
        
        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal(modalId);
            }
        });
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        
        // Add closing animation
        modal.querySelector('div:first-child').classList.remove('ease-out', 'duration-300', 'opacity-100', 'scale-100');
        modal.querySelector('div:first-child').classList.add('ease-in', 'duration-200', 'opacity-0', 'scale-95');
        
        // Hide modal after animation completes
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }

    // Initialize tooltips
    function initTooltips() {
        const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
        tooltipTriggers.forEach(trigger => {
            trigger.addEventListener('mouseenter', () => {
                const tooltipText = trigger.getAttribute('data-tooltip');
                const tooltip = document.createElement('div');
                tooltip.classList.add('absolute', 'z-10', 'bg-gray-900', 'text-white', 'text-xs', 'rounded', 'py-1', 'px-2', 
                                    'opacity-0', 'transition-opacity', 'duration-300');
                tooltip.textContent = tooltipText;
                
                // Position the tooltip
                trigger.style.position = 'relative';
                trigger.appendChild(tooltip);
                
                // Show tooltip
                setTimeout(() => {
                    tooltip.classList.remove('opacity-0');
                    tooltip.classList.add('opacity-100');
                }, 10);
            });
            
            trigger.addEventListener('mouseleave', () => {
                const tooltip = trigger.querySelector('div');
                if (tooltip) {
                    tooltip.classList.remove('opacity-100');
                    tooltip.classList.add('opacity-0');
                    setTimeout(() => {
                        tooltip.remove();
                    }, 300);
                }
            });
        });
    }

    // Initialize responsive behavior
    function initResponsiveLayout() {
        const updateLayout = () => {
            // Add specific layout adjustments if needed based on screen width
            const isMobile = window.innerWidth < 640;
            const isTablet = window.innerWidth >= 640 && window.innerWidth < 1024;
            
            // You can add specific class toggles for different screen sizes here
            document.querySelectorAll('.responsive-element').forEach(el => {
                if (isMobile) {
                    el.classList.add('mobile-view');
                    el.classList.remove('tablet-view', 'desktop-view');
                } else if (isTablet) {
                    el.classList.add('tablet-view');
                    el.classList.remove('mobile-view', 'desktop-view');
                } else {
                    el.classList.add('desktop-view');
                    el.classList.remove('mobile-view', 'tablet-view');
                }
            });
        };
        
        // Initial call
        updateLayout();
        
        // Update on resize
        window.addEventListener('resize', updateLayout);
    }

    // Run initializations when DOM content is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initTooltips();
        initResponsiveLayout();
    });
</script>
@endsection