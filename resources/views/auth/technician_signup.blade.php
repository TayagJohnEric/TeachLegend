<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
</head>
<body class="min-h-screen font-sans flex flex-col items-center justify-center p-4" style="font-family: 'Inter', sans-serif;">
    
    <div class="bg-white p-8 w-full max-w-md">
        <div class="flex justify-center mb-6">
            <a href="{{ route('landingpage') }}">
                <img src="{{ asset('images/logo_icon.png') }}" alt="Logo" class="w-10 h-10">
            </a>
        </div>

        <h1 class="text-xl font-bold text-center text-gray-800">Technician Sign up</h1>
        <p class="text-sm text-gray-400 mb-6 text-center">
            Join our technician network to provide expert services and grow your business with us.
        </p>

        <form action="{{ route('technician.register') }}" method="POST" class="space-y-6 mt-10">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-bold text-gray-700 mb-1">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="John" required 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-bold text-gray-700 mb-1">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required placeholder="Doe" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="johndoe@example.com"
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-1">Phone Number <span class="text-gray-500 text-xs">(Optional)</span></label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="09XX-XXX-XXXX"
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none" data-target="password">
                        <i data-feather="eye"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long.</p>
            </div>
            
            <div>
                <button type="submit" 
                    class="text-sm w-full py-2 px-4 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-md transition duration-200">
                    Register as Technician
                </button>
            </div>
            
            <div class="text-center text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a>
            </div>
        </form>
    </div>
    <div class="text-center text-xs text-gray-400 mt-4 w-full max-w-md">
        © 2025 Created & Developed by John Eric Tayag. All rights reserved.
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            document.querySelectorAll('.password-toggle').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.setAttribute('data-feather', 'eye-off');
                    } else {
                        passwordInput.type = 'password';
                        icon.setAttribute('data-feather', 'eye');
                    }
                    feather.replace();
                });
            });
        });
    </script>
</body>
</html>