<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard')</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
      /* Modal background overlay */
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
  <div>
    <!-- Sidebar Menu -->
    @include('components.admin.sidebar')

    <!-- Content Area -->
    <div class="flex-1 flex flex-col w-full">
      <!-- Top Navigation Bar -->
      @include('components.admin.top_navbar')
      
      <!-- Main Content Area -->
      @yield('content')
      
    </div>
  </div>
</body>
</html>
