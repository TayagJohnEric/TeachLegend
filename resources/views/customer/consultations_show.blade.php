@extends('layouts.customer.app')

@section('title', 'Consultation')

@section('content')

<div class="container mx-auto py-6 px-4">
    <div class="max-w-4xl mx-auto">
      <!-- Header Section -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold mb-3 md:mb-0">Consultation Request #{{ $consultationRequest->id }}</h2>
        <a href="{{ route('consultations.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Requests
        </a>
      </div>
  
      <!-- Alerts -->
      @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md flex items-start" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <div class="text-green-700">{{ session('success') }}</div>
          <button type="button" class="ml-auto text-green-500 hover:text-green-700" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      @endif
      
      @if (session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md flex items-start" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <div class="text-red-700">{{ session('error') }}</div>
          <button type="button" class="ml-auto text-red-500 hover:text-red-700" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      @endif
  
      <!-- Main Card -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <!-- Status Banner -->
        <div class="w-full">
          <div class="bg-{{ 
            $consultationRequest->status === 'pending' ? 'yellow-500' : 
            ($consultationRequest->status === 'in_progress' ? 'blue-500' : 
            ($consultationRequest->status === 'resolved' ? 'green-500' : 'gray-500'))
          }} text-white p-4 flex justify-between items-center">
            <h5 class="font-medium text-lg">Request Details</h5>
            <span class="bg-white text-{{ 
              $consultationRequest->status === 'pending' ? 'yellow-500' : 
              ($consultationRequest->status === 'in_progress' ? 'blue-500' : 
              ($consultationRequest->status === 'resolved' ? 'green-500' : 'gray-500'))
            }} px-3 py-1 rounded-full font-semibold text-sm">
              {{ ucfirst($consultationRequest->status) }}
            </span>
          </div>
        </div>
        
        <!-- Request Details Body -->
        <div class="p-6">
          <div class="mb-6">
            <p class="text-lg text-gray-800 mb-4">{{ $consultationRequest->request_details }}</p>
            <div class="flex items-center text-gray-500 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Submitted on: {{ $consultationRequest->created_at->format('M d, Y') }} at {{ $consultationRequest->created_at->format('H:i') }}
            </div>
          </div>
  
          <!-- Timeline and Responses -->
          <h5 class="border-b border-gray-200 pb-2 mb-4 flex items-center font-medium text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            Conversation History ({{ $consultationRequest->responses->count() }})
          </h5>
          
          @if ($consultationRequest->responses->count() > 0)
            <div class="space-y-4 mb-6">
              @foreach ($consultationRequest->responses as $response)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                  <div class="bg-gray-50 p-4 rounded-t-lg">
                    <div class="flex flex-col md:flex-row justify-between">
                      <div class="flex items-center mb-2 md:mb-0">
                        <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3 flex-shrink-0">
                          {{ substr($response->technician->first_name, 0, 1) }}{{ substr($response->technician->last_name, 0, 1) }}
                        </div>
                        <div>
                          <div class="font-semibold">{{ $response->technician->first_name }} {{ $response->technician->last_name }}</div>
                          <div class="text-gray-500 text-sm">{{ ucfirst($response->technician->role) }}</div>
                        </div>
                      </div>
                      <div class="flex items-center text-gray-500 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $response->created_at->format('M d, Y') }} at {{ $response->created_at->format('H:i') }}
                      </div>
                    </div>
                  </div>
                  <div class="p-5">
                    <p class="text-gray-700">{{ $response->message }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md flex items-start mb-6" role="alert">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
              </svg>
              <div class="text-blue-700">
                No responses yet. Our technical team will review your request soon.
              </div>
            </div>
          @endif
  
          <!-- Action Buttons -->
          @if ($consultationRequest->status === 'resolved')
            <div class="mt-6">
              <form action="{{ route('consultations.close', $consultationRequest->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md transition-colors inline-flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  Mark as Closed
                </button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection