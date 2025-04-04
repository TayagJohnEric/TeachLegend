@extends('layouts.technician.app')

@section('title', 'Booking Details')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header with back button -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">Booking Details #{{ $booking->id }}</h1>
            <a href="{{ route('technician.bookings.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to All Bookings
            </a>
        </div>

        <div class="px-6 py-5">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Information Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Booking Information -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-700">Booking Information</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Service Type:</div>
                            <div class="col-span-2 text-gray-700">{{ $booking->service_type }}</div>
                        </div>
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Status:</div>
                            <div class="col-span-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $booking->status == 'assigned' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($booking->status == 'in-progress' ? 'bg-blue-100 text-blue-800' : 
                                    ($booking->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                    ($booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    {{ ucfirst(str_replace('-', ' ', $booking->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Appointment:</div>
                            <div class="col-span-2 text-gray-700">{{ $booking->appointment_date->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Created On:</div>
                            <div class="col-span-2 text-gray-700">{{ $booking->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-700">Customer Information</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Name:</div>
                            <div class="col-span-2 text-gray-700">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</div>
                        </div>
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Email:</div>
                            <div class="col-span-2 text-gray-700">
                                <a href="mailto:{{ $booking->user->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $booking->user->email }}
                                </a>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 px-4 py-3">
                            <div class="col-span-1 font-medium text-gray-700">Phone:</div>
                            <div class="col-span-2 text-gray-700">
                                @if($booking->user->phone_number)
                                    <a href="tel:{{ $booking->user->phone_number }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $booking->user->phone_number }}
                                    </a>
                                @else
                                    <span class="text-gray-500 italic">Not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-700">Notes</h2>
                </div>
                <div class="p-4">
                    @if($booking->notes)
                        <div class="bg-gray-50 p-4 rounded-md mb-4 text-gray-700 border border-gray-200">
                            {{ $booking->notes }}
                        </div>
                    @else
                        <p class="text-gray-500 italic mb-4">No notes have been added to this booking.</p>
                    @endif

                    <form action="{{ route('technician.bookings.add-notes', $booking) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Add/Update Notes:</label>
                            <textarea name="notes" id="notes" rows="3" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md @error('notes') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save Notes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-3">
                <div class="flex flex-wrap gap-3">
                    @if($booking->status === 'assigned')
                        <form action="{{ route('technician.bookings.accept', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Accept Booking
                            </button>
                        </form>
                    @endif
                    
                    @if($booking->status === 'in-progress')
                        <form action="{{ route('technician.bookings.complete', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mark as Completed
                            </button>
                        </form>
                    @endif
                </div>
                
                @if(in_array($booking->status, ['assigned', 'in-progress']))
                    <form action="{{ route('technician.bookings.cancel', $booking) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to cancel this booking?')">
                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel Booking
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection