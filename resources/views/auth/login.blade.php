<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"></script>
</head>
<body class=" min-h-screen font-sans flex flex-col items-center justify-center p-4" style="font-family: 'Inter', sans-serif;">
    
    <div class="bg-white p-8  w-full max-w-md">
        <div class="flex justify-center mb-6">
            <a href="{{ route('landingpage') }}">
                <img src="{{ asset('images/logo_icon.png') }}" alt="Logo" class="w-10 h-10">
            </a>
        </div>

        <h1 class="text-xl font-bold text-center text-gray-800">Sign In</h1>
        <p class="text-sm text-gray-400 mb-6 text-center">Welcome back! Please login to your account</p>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-md text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6 mt-10">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="johndoe@example.com"
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
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
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                <div class="text-sm">
                    <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
                </div>
            </div>
            
            <div>
                <button type="submit" 
                    class="text-sm w-full py-2 px-4 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-md transition duration-200">
                    Sign In
                </button>
            </div>
            
            <div class="text-center text-sm text-gray-600">
                Don't have an account? <a href="{{route('register')}}" class="text-blue-600 hover:underline">Create account</a>
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