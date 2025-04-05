@extends('layouts.technician.app')

@section('title', 'Consultation Request Details')



@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header with action buttons -->
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-900">Consultation Request #{{ $consultationRequest->id }}</h1>
                <span class="ml-3 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $consultationRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                    ($consultationRequest->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                    ($consultationRequest->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ ucfirst($consultationRequest->status) }}
                </span>
            </div>
            <a href="{{ route('technician.consultations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="mr-2 -ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>

        <!-- Success alert -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-6 mt-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="p-6">
            <!-- Customer request details -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium mr-3">
                                {{ substr($consultationRequest->user->first_name, 0, 1) }}{{ substr($consultationRequest->user->last_name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $consultationRequest->user->first_name }} {{ $consultationRequest->user->last_name }}</h3>
                                <p class="text-xs text-gray-500">Customer</p>
                            </div>
                        </div>
                        <div class="mt-2 sm:mt-0 text-xs text-gray-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $consultationRequest->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4">
                    <div class="prose max-w-none">
                        <p class="text-gray-700">{{ $consultationRequest->request_details }}</p>
                    </div>
                </div>
            </div>

            <!-- Status update section -->
            @if ($consultationRequest->status !== 'closed')
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                        <h3 class="text-sm font-medium text-gray-900">Update Status</h3>
                    </div>
                    <div class="px-4 py-4">
                        <form action="{{ route('technician.consultations.updateStatus', $consultationRequest->id) }}" method="POST" class="flex flex-col sm:flex-row sm:items-center gap-3">
                            @csrf
                            @method('PATCH')
                            <div class="w-full sm:w-64">
                                <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="in_progress" {{ $consultationRequest->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $consultationRequest->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Responses section -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Responses ({{ $consultationRequest->responses->count() }})
                </h3>

                @if ($consultationRequest->responses->count() > 0)
                    <div class="space-y-4">
                        @foreach ($consultationRequest->responses as $response)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-medium mr-3">
                                                {{ substr($response->technician->first_name, 0, 1) }}{{ substr($response->technician->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $response->technician->first_name }} {{ $response->technician->last_name }}</h4>
                                                <p class="text-xs text-gray-500">{{ ucfirst($response->technician->role) }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 sm:mt-0 text-xs text-gray-500">
                                            {{ $response->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-4">
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700">{{ $response->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1 md:flex md:justify-between">
                                <p class="text-sm text-blue-700">
                                    No responses have been added yet.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Add response form -->
            @if ($consultationRequest->status !== 'closed')
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                        <h3 class="text-sm font-medium text-gray-900">Add Response</h3>
                    </div>
                    <div class="px-4 py-4">
                        <form action="{{ route('technician.consultations.storeResponse', $consultationRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea name="message" id="message" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('message') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Type your response here...">{{ old('message') }}</textarea>
                                
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-end">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Submit Response
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection