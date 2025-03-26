<div class="flex h-screen">
  <!-- Mobile Overlay Backdrop -->
  <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>
  
  <div id="sidebar" class="fixed lg:sticky xl:sticky top-0 inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 xl:translate-x-0 w-64 bg-white border-r border-gray-200 flex flex-col shadow-lg z-30 transition-transform duration-300 ease-in-out h-screen overflow-hidden">
    <!-- Logo/Title -->
    <div class="p-4 border-b border-gray-200">
      <h1 class="text-xl font-semibold text-gray-800">TechStore</h1>
    </div>
    
    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto py-2">

      <a href="{{ route('admin.dashboard') }}" 
   class="flex items-center px-4 py-3 rounded-md transition-colors 
          {{ request()->is('admin/dashboard') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
  </svg>
  <span class="font-medium">Dashboard</span>
</a>


        <a href="{{ route('admin.products.index') }}" 
   class="flex items-center px-4 py-3 rounded-md transition-colors 
          {{ request()->is('admin/products') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
  </svg>
  <span class="font-medium">Manage Products</span>
</a>


        <a href="/services" class="flex items-center px-4 py-3 rounded-md transition-colors text-gray-700 hover:bg-gray-100 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          <span class="font-medium">Manage Users</span>
        </a>

       <a href="{{ route('admin.orders.index') }}" 
   class="flex items-center px-4 py-3 rounded-md transition-colors 
          {{ request()->is('admin/orders') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
  </svg>
  <span class="font-medium">Manage Orders</span>
</a>


        <a href="/trade-in" class="flex items-center px-4 py-3 rounded-md transition-colors text-gray-700 hover:bg-gray-100 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
          <span class="font-medium">Service Bookings</span>
        </a>

        <a href="/trade-in/listings" class="flex items-center px-4 py-3 rounded-md transition-colors text-gray-700 hover:bg-gray-100 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span class="font-medium">Moderate Reviews</span>
        </a>

        <a href="/orders" class="flex items-center px-4 py-3 rounded-md transition-colors text-gray-700 hover:bg-gray-100 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          <span class="font-medium">Manage Trade-Ins</span>
        </a>

        <a href="/subscriptions" class="flex items-center px-4 py-3 rounded-md transition-colors text-gray-700 hover:bg-gray-100 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
          </svg>
          <span class="font-medium">Manage Subscriptions</span>
        </a>
      </nav>
    </div>
  </div>
</div>

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('-translate-x-full');
  document.getElementById('sidebar-backdrop').classList.toggle('hidden');
}
</script>
