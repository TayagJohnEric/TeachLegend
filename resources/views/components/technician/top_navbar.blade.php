<!-- Top Navigation Bar -->
<div class="z-10">
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
      
      <!-- Right Side - Search, Notifications, and Profile -->
      <div class="flex items-center space-x-4">
  
        <div class="relative">
          <a href="#" class="p-1 text-gray-600 hover:text-gray-900 focus:outline-none">
            <div class="bg-white p-1.5 rounded-full border border-gray-200 relative">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 5a2 2 0 114 0 7 7 0 014 6v3a4 4 0 002 3H4a4 4 0 002-3v-3a7 7 0 014-6M9 17v1a3 3 0 106 0v-1"
                />
              </svg>
              <!-- Notification indicator -->
              <div id="notification-indicator" class="hidden absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></div>
            </div>
          </a>
        </div>
        <!-- Profile Dropdown -->
        @include('components.profile')
  
      </div>
    </div>
  </div>
  