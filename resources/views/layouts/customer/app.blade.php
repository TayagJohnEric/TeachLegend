<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', "Customer Dashboard")</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    html, body {
      width: 100%;
      overflow-x: hidden;
      font-family: 'Inter', sans-serif;
    }
  
    /* Modal background overlay */
    .modal-overlay {
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    /* Modal container */
    .modal-container {
      opacity: 0;
      transform: scale(0.95);
      transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Active class to show modal */
    .modal-active .modal-overlay {
      opacity: 1;
    }

    .modal-active .modal-container {
      opacity: 1;
      transform: scale(1);
    }
  </style>
</head>
<body class="bg-[#F6F5FA]">
  <div class="flex h-screen overflow-hidden">
    <!-- Mobile Overlay Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div id="sidebar" class="fixed lg:relative xl:relative inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 xl:translate-x-0 w-64 bg-white shadow-sm flex flex-col z-30 transition-transform duration-300 ease-in-out h-screen overflow-hidden">
      <!-- Logo/Title -->
      <div class="p-4 flex">
        <h1 class="text-xl font-semibold text-gray-800 text-center">TechStore</h1>
      </div>
      
      <!-- Menu Items -->
      <div class="flex-1 overflow-y-auto py-2">
        <nav class="mt-2">
          <!-- Main Navigation -->
          <div class="px-4 py-2">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h2>
          </div>
          
          <a href="{{ route('customer.dashboard') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('customer/dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="font-medium">Dashboard</span>
          </a>
          
          <a href="{{ route('products.index') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('products') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
            <span class="font-medium">Browse Products</span>
          </a>
          
          <a href="{{ route('pc-builder.index') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('pc-builder') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
            </svg>
            <span class="font-medium">PC Builder</span>
          </a>
          
          <!-- Services Section -->
          <div class="px-4 py-2 mt-4">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Services</h2>
          </div>
          
          <a href="{{ route('customer.services') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('customer/services') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium">Services</span>
          </a>
          
          <a href="{{ route('customer.bookings') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('customer/bookings') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">My Bookings</span>
          </a>
          
       
          
          <!-- Trade-In Marketplace Section -->
          <div class="px-4 py-2 mt-4">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Trade-In</h2>
          </div>
          
          <a href="{{ route('trade-in.index') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('trade-in') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                  </svg>
            <span class="font-medium">Marketplace</span>
          </a>
          
          <a href="{{ route('trade-in.create') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('trade-in/create') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">Create Listing</span>
          </a>
          
          <a href="{{ route('trade-in.my-listings') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('my-listing') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="font-medium">My Listings</span>
          </a>
          
          <!-- Orders Section -->
          <div class="px-4 py-2 mt-4">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Orders</h2>
          </div>
          
          <a href="{{ route('customer.orders') }}" 
            class="flex items-center px-4 py-3 rounded-md transition-colors 
                  {{ request()->is('customer/orders') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="font-medium">My Orders</span>
          </a>
        </nav>
      </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
      <!-- Top Navigation Bar -->
      @include('components.customer.top_navbar')

      <!-- Scrollable Content -->
      <div class="flex-1 overflow-y-auto">
        @yield('content')
      </div>
    </div>
  </div>

  <script>  
   // Mobile sidebar toggle
   function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    
    sidebar.classList.toggle('-translate-x-full');
    backdrop.classList.toggle('hidden');
  }

  // Products dropdown menu
  const productsButton = document.getElementById('products-menu-button');
    const productsDropdown = document.getElementById('products-dropdown');
    const productsChevron = document.getElementById('products-chevron');
    
    if (productsButton) {
      productsButton.addEventListener('click', function() {
        productsDropdown.classList.toggle('hidden');
        productsChevron.classList.toggle('rotate-180');
      });
    }
  </script>
</body>
</html>