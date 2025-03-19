<!-- Top Navigation Bar -->
<div class="z-10">
    <div class="px-4 py-3 flex justify-between items-center">
      
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
  
  
        <!-- Profile Dropdown -->
        @include('components.profile')
  
      </div>
    </div>
  </div>
  