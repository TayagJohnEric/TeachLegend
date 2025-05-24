@extends('layouts.technician.app')
@section('title', 'Technician Dashboard')
@section('content')
<div class="container mx-auto px-4 py-6 max-w-[112rem]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Total Services Card -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Services</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalServices }}</p>
                </div>
                <div class="text-blue-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-6h13v6M9 17H5a2 2 0 01-2-2v-4a2 2 0 012-2h4v6z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- All Consultation Requests Card -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">All Consultation Requests</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalConsultations }}</p>
                </div>
                <div class="text-green-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
