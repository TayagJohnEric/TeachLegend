@extends('layouts.technician.app')
@section('title', 'Booking Details')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-2xl font-bold text-gray-900">Booking Details </h1>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('technician.bookings.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to All Bookings
            </a>
        </div>
        
    </div>

    <!-- Notification Messages -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                <!-- Booking Information -->
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Service Type</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">{{ $booking->service_type }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'completed' ? ' bg-green-100 text-green-800' : '' }}
                                {{ $booking->status === 'in-progress' ? ' bg-blue-100 text-blue-800' : '' }}
                                {{ $booking->status === 'assigned' ? ' bg-yellow-100 text-yellow-800' : '' }}
                                {{ $booking->status === 'cancelled' ? ' bg-red-100 text-red-800' : '' }}
                                {{ $booking->status === 'approved' ? ' bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst(str_replace('-', ' ', $booking->status)) }}
                            </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Appointment</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">{{ $booking->appointment_date->format('M d, Y h:i A') }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created On</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">{{ $booking->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Name</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Email</div>
                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->email }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Phone</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">
                                @if($booking->user->phone_number)
                                    {{ $booking->user->phone_number }}
                                @else
                                    <span class="text-gray-500 italic">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Actions -->
        <div class="lg:col-span-1">
            <div class="space-y-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Actions</h2>
                        <div class="space-y-3">
                            @if($booking->status === 'assigned')
                                <form action="{{ route('technician.bookings.accept', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 13l4 4L19 7" />
                                        </svg>
                                        Accept Booking
                                    </button>
                                </form>
                            @endif

                            @if($booking->status === 'in-progress')
                                <form action="{{ route('technician.bookings.complete', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif

                            @if(in_array($booking->status, ['assigned', 'in-progress']))
                                <form action="{{ route('technician.bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End of grid -->

    <!-- Full Width Notes Section -->
    <div class="mt-6 lg:col-span-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Note:</h2>
                
                @if($booking->notes)
                    <div class="bg-gray-50 p-4 rounded-md mb-4">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $booking->notes }}</p>
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic mb-4">No notes have been added to this booking.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
