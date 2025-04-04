<div class="flex h-screen">
    <!-- Mobile Overlay Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>
    
    <div id="sidebar" class="fixed lg:sticky xl:sticky top-0 inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 xl:translate-x-0 w-64 bg-white shadow-sm flex flex-col z-30 transition-transform duration-300 ease-in-out h-screen overflow-hidden">
      <!-- Logo/Title -->
      <div class="p-4 border-b border-gray-200">
        <h1 class="text-xl font-semibold text-gray-800">TechPortal</h1>
      </div>
      
      <!-- Menu Items -->
      <div class="flex-1 overflow-y-auto py-2">
        <a href="#" 
           class="flex items-center px-4 py-3 rounded-md transition-colors 
                 # ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span class="font-medium">Dashboard</span>
        </a>
  
        <a href="#" 
           class="flex items-center px-4 py-3 rounded-md transition-colors 
                  # ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span class="font-medium">Service Bookings</span>
        </a>
  
        <a href="#" 
           class="flex items-center px-4 py-3 rounded-md transition-colors 
                 # ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l4-4h-.586A1.994 1.994 0 019 12.414" />
          </svg>
          <span class="font-medium">Consultation Requests</span>
        </a>
      </div>
    </div>
  </div>
  
  <script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebar-backdrop').classList.toggle('hidden');
  }
  </script>