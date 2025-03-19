@extends('layouts.customer.app')

<!-- Main Content -->
@section('content')
<div class="flex-1 overflow-y-auto p-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>
    <!-- Dashboard content with enhanced visuals -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Total Orders - Green for positive metrics -->
      <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg shadow border-l-4 border-green-500">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-medium text-gray-700 flex items-center gap-2">
              <!-- Shopping cart icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Total Orders
            </h3>
            <p class="text-3xl font-bold mt-2 text-green-700">12</p>
            <p class="text-sm text-green-600 font-medium flex items-center mt-1">
              <!-- Up arrow icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
              </svg>
              +8% from last week
            </p>
          </div>
          <div class="bg-green-500 rounded-full p-2 text-white">
            <!-- Shopping cart icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Pending Orders - Amber/Yellow for items requiring attention -->
      <div class="bg-gradient-to-r from-amber-50 to-amber-100 p-4 rounded-lg shadow border-l-4 border-amber-500">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-medium text-gray-700 flex items-center gap-2">
              <!-- Clock icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Pending Orders
            </h3>
            <p class="text-3xl font-bold mt-2 text-amber-700">164</p>
            <p class="text-sm text-amber-600 font-medium mt-1">Needs attention</p>
          </div>
          <div class="bg-amber-500 rounded-full p-2 text-white">
            <!-- Clock icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Recently Purchased Items - Blue for informational metrics -->
      <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg shadow border-l-4 border-blue-500">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-medium text-gray-700 flex items-center gap-2">
              <!-- Package icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
              Recently Purchased Items
            </h3>
            <p class="text-3xl font-bold mt-2 text-blue-700">52</p>
            <p class="text-sm text-blue-600 font-medium mt-1">Last 24 hours</p>
          </div>
          <div class="bg-blue-500 rounded-full p-2 text-white">
            <!-- Package icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection