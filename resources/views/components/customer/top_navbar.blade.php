<!-- Top Navigation Bar -->
<div class="z-10 ">
    <div class="bg-white shadow-sm px-4 py-0 flex justify-between items-center">
      
      <!-- Left Side - Burger Menu (Mobile Only) -->
      <div class="flex items-center">
        <button
          id="burger-menu"
          class="lg:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none"
          onclick="toggleSidebar()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <h1 class="ml-2 text-xl font-semibold text-gray-800 lg:hidden">TechStore</h1>
      </div>
      
      <!-- Right Side - Search, Cart, Profile -->
      <div class="flex items-center space-x-4">
  
        <!-- Search Bar -->
        @include('components.searchbar')

   
       <!-- Cart Icon with Counter -->
<div class="relative">
  <a href="{{ route('cart.view')}}" class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
    <div class="bg-white p-2 rounded-full border border-gray-200 relative ">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
        />
      </svg>
    </div>
  </a>
</div>

<!-- My PC Builds Icon -->
<div class="relative">
  <a href="{{ route('pc-builder.list')}}" class="p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
    <div class="bg-white p-2 rounded-full border border-gray-200 relative ">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"
        />
      </svg>
    </div>
  </a>
</div>
  
        <!-- Profile Dropdown -->
        @include('components.profile')
  
      </div>
    </div>
  </div>
  