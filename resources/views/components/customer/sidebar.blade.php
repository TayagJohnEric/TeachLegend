<div class="flex h-screen">
    <!-- Mobile Overlay Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>
    
    <div id="sidebar" class="fixed lg:sticky xl:sticky top-0 inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 xl:translate-x-0 w-64 bg-white shadow-sm flex flex-col  z-30 transition-transform duration-300 ease-in-out h-screen overflow-hidden">
      <!-- Logo/Title -->
<div class="p-4 flex ">
  <h1 class="text-xl font-semibold text-gray-800 text-center">TechStore</h1>
</div>
      
      <!-- Menu Items -->
      <div class="flex-1 overflow-y-auto py-2">
        <nav class="mt-2">
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
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
           </svg>
           <span class="font-medium">Browse Products</span>
       </a>

       <a href="{{ route('trade-in.index') }}" 
       class="flex items-center px-4 py-3 rounded-md transition-colors 
              {{ request()->is('trade-in') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <span class="font-medium">Trade-In Marketplace</span>
    </a>
            
       <a href="{{ route('pc-builder.index') }}" 
       class="flex items-center px-4 py-3 rounded-md transition-colors 
              {{ request()->is('pc-builder') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
              </svg>
              <span class="font-medium">PC Builder</span>
       </a>
            
       <a href="{{ route('customer.services') }}" 
       class="flex items-center px-4 py-3 rounded-md transition-colors 
              {{ request()->is('customer/services') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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
            
            
 <a href="{{ route('trade-in.create') }}" 
 class="flex items-center px-4 py-3 rounded-md transition-colors 
        {{ request()->is('trade-in/create') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
  <span class="font-medium">Trade-In</span>
</a>
            
<a href="{{ route('trade-in.my-listings') }}" 
class="flex items-center px-4 py-3 rounded-md transition-colors 
       {{ request()->is('my-listing') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
         </svg>
 <span class="font-medium">My Listings</span>
</a>
            
            <a href="{{ route('customer.orders') }}" 
   class="flex items-center px-4 py-3 rounded-md transition-colors 
          {{ request()->is('customer/orders') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
    </svg>
    <span class="font-medium">My Orders</span>
</a>
            
            <a href="/subscriptions" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-md transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
              <span class="font-medium">Subscriptions</span>
            </a>
          </nav>
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
      
      productsButton.addEventListener('click', function() {
        productsDropdown.classList.toggle('hidden');
        productsChevron.classList.toggle('rotate-180');
      });
    </script>