@extends('layouts.customer.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">

    <!-- Total Orders Card -->
    <div class="bg-white shadow rounded-lg p-5">
        <div class="text-gray-500">Total Orders</div>
        <div class="text-3xl font-bold text-indigo-600">{{ $totalOrders }}</div>
    </div>

    <!-- Total Consultation Requests Card -->
    <div class="bg-white shadow rounded-lg p-5">
        <div class="text-gray-500">Total Consultation Requests</div>
        <div class="text-3xl font-bold text-green-600">{{ $totalConsultations }}</div>
    </div>

    <!-- Today's Booking Card -->
    <div class="p-5 rounded-lg shadow {{ $todayBooking ? 'bg-blue-100 border-l-4 border-blue-500' : 'bg-gray-100 border-l-4 border-gray-400' }}">
        <div class="flex items-center justify-between">
            <div class="text-gray-700 font-semibold">Today's Booking</div>
            <span class="text-sm px-3 py-1 rounded-full font-medium {{ $todayBooking ? 'bg-blue-500 text-white' : 'bg-gray-400 text-white' }}">
                {{ $todayBooking ? 'Scheduled' : 'No Booking' }}
            </span>
        </div>
    </div>

</div>
@endsection
