<!-- Profile Dropdown -->
<div class="relative">
    <button class="flex items-center space-x-2 focus:outline-none" id="profileDropdown">
      <img src="https://via.placeholder.com/40" alt="Profile" class="h-8 w-8 rounded-full object-cover border border-gray-300">
    </button>
  
    <!-- Profile Dropdown Menu -->
    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-10">
      
      <!-- Profile Info -->
<div class="px-4 py-3 border-b border-gray-200 text-gray-800">
    <p class="font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
</div>
  
      <a href="/profile" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-md transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="font-medium text-sm">Your Profile</span>
      </a>
  
      <a href="/settings" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-md transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="font-medium text-sm">Settings</span>
      </a>
  
      <a href="/orders" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-md transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <span class="font-medium text-sm">Your Orders</span>
      </a>
  
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <div class="border-t border-gray-100"></div>
        <button type="submit" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-md transition-colors w-full text-left">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="font-medium text-sm">Log out</span>
        </button>
      </form>
  
    </div>
  </div>
  
  <script>
    // Profile dropdown toggle
    const profileButton = document.getElementById('profileDropdown');
    const profileDropdown = document.getElementById('profile-dropdown');
  
    profileButton.addEventListener('click', function() {
      profileDropdown.classList.toggle('hidden');
    });
  
    // Close profile dropdown when clicking outside
    document.addEventListener('click', function(event) {
      if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
        profileDropdown.classList.add('hidden');
      }
    });
  </script>
  