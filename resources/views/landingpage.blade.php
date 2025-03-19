<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech of Legends - Premium Computer Parts & Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Inter font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Geist Font for the Marquee -->
    <link rel="stylesheet" href="https://geist-fonts.vercel.app/stylesheet.css">
    <!-- Configure Tailwind to use Inter as the default font -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .wrapper {
  width: 50%; /* Reduced from 100% to 80% */
  position: relative;
  height: 50px; /* Reduced height to match the smaller font size */
  margin: 0 auto; /* Center the marquee */
  overflow: hidden;
  mask-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1) 20%, rgba(0, 0, 0, 1) 80%, rgba(0, 0, 0, 0));
  -webkit-mask-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1) 20%, rgba(0, 0, 0, 1) 80%, rgba(0, 0, 0, 0));
}
.marquee-track {
    padding-top: 10px;
  display: flex;
  width: fit-content;
  animation: scroll 20s linear infinite;
}
.marquee-content {
  display: flex;
  align-items: center;
  white-space: nowrap;
}
.item {
  display: flex;
  align-items: center;
  font-size: 17px; /* Reduced from 24px to 18px */
  padding: 0 16px; /* Slightly reduced padding */
  color: #575656;
  font-weight: 300;
  font-family: "Inter", sans-serif;
}
.divider {
  font-size: 18px; /* Reduced from 24px to 18px */
  opacity: 0.5;
  margin: 0 30px; /* Reduced from 40px to 30px */
}
@keyframes scroll {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50%);
  }
}
    </style>
</head>
<body class="font-sans text-gray-800 bg-gray-50">
  <!-- Navigation -->
<nav class="bg-gray-900 text-white p-4 sticky top-0 z-10 shadow-lg">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
             <a href="{{ route('landingpage') }}">
                <img src="{{asset('images/logo.png')}}" alt="Tech Legends Logo" class="h-10">
             </a>
            </div>
            <!-- Desktop navigation - centered -->
            <div id="desktop-menu" class="hidden md:flex items-center space-x-6 flex-grow justify-center">
                <a href="#home" class="hover:text-blue-400 transition">Home</a>
                <a href="#products" class="hover:text-blue-400 transition">Products</a>
                <a href="#benefits" class="hover:text-blue-400 transition">Why Us</a>
                <a href="#testimonials" class="hover:text-blue-400 transition">Reviews</a>
                <a href="#contact" class="hover:text-blue-400 transition">Contact</a>
            </div>
            <!-- Login and Sign Up buttons - aligned to the right -->
            <div class="hidden md:flex items-center space-x-4 ml-auto">
                <a href="{{route('login')}}" class="bg-transparent border border-blue-500 hover:bg-blue-600 px-4 py-1 rounded-full transition">Login</a>
                <a href="{{route('register')}}" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-1 rounded-full transition">Sign Up</a>
            </div>
            <!-- Mobile menu button - pushed to the right -->
            <div class="md:hidden ml-auto">
                <button id="mobile-menu-button" class="focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile navigation menu - shown only when toggled -->
        <div id="mobile-menu" class="hidden mt-4  md:hidden">
            <div class="flex flex-col  space-y-2">
                <a href="#home" class="hover:text-blue-400 transition">Home</a>
                <a href="#products" class="hover:text-blue-400 transition">Products</a>
                <a href="#benefits" class="hover:text-blue-400 transition">Why Us</a>
                <a href="#testimonials" class="hover:text-blue-400 transition">Reviews</a>
                <a href="#contact" class="hover:text-blue-400 transition">Contact</a>
                <div class="flex flex-col space-y-2 pt-2">
                    <a href="{{route('login')}}" class="text-center bg-transparent border border-blue-500 hover:bg-blue-500 px-4 py-1 rounded-full transition">Login</a>
                    <a href="{{route('register')}}" class="text-center bg-blue-500 hover:bg-blue-600 px-4 py-1 rounded-full transition">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Hero Section -->
<section id="home" class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-20">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
        <!-- Hero Text - Centered on mobile, left-aligned on md and up -->
        <div class="w-full md:w-1/2 text-center md:text-left mb-8 md:mb-0">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fade-in">
                Level Up Your <span class="text-yellow-400">Tech Game</span>
            </h2>
            <p class="text-lg md:text-xl mb-6">
                Premium computer parts and accessories for gamers, creators, and professionals who demand the best.
            </p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="#products" class="bg-amber-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                </a>
                <a href="#benefits" class="bg-transparent border-2 border-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-700 transition flex items-center justify-center">
                    <i class="fas fa-info-circle mr-2"></i> Learn More
                </a>
            </div>
        </div>
        <!-- Hero Image - Hidden on mobile (xs/sm), larger on iPad (md), normal on desktop (lg+) -->
        <div class="hidden md:block md:w-1/2 relative">
            <div class="relative md:w-5/6 lg:w-3/4 mx-auto">
                <div class="overflow-hidden rounded-lg">
                    <img src="{{asset('images/hero-image.png')}}" alt="NVIDIA GeForce RTX 4090 Founders Edition Graphics Card 24GB"
                         class="w-full transition-transform duration-300 hover:scale-110">
                </div>
                <!-- Deal Badges - Adjusted for iPad size -->
                <div class="absolute top-5 left-8 bg-red-600 text-white py-2 px-4 md:py-2 md:px-3 lg:py-3 lg:px-5 rounded-full shadow-lg transform rotate-12 transition-transform duration-300 hover:scale-110">
                    <span class="block font-bold text-sm lg:text-base">NEW</span>
                </div>
                <div class="absolute top-6 right-10 bg-amber-500 text-white py-1 px-3 md:py-1 md:px-2 lg:py-2 lg:px-4 rounded-md shadow-lg transition-transform duration-300 hover:scale-110">
                    <span class="block font-bold text-xs md:text-xs lg:text-sm">LIMITED STOCK</span>
                </div>
                <div class="absolute top-1/3 left-2 bg-green-600 text-white py-1 px-3 md:py-1 md:px-2 lg:py-2 lg:px-4 rounded-md shadow-lg transform -rotate-6 transition-transform duration-300 hover:scale-110">
                    <span class="block font-bold text-xs md:text-xs lg:text-sm">SALE</span>
                    <span class="block text-xs md:text-xs lg:text-sm">Save 15%</span>
                </div>
                <div class="absolute bottom-7 right-2 bg-blue-500 text-white py-1 px-3 md:py-1 md:px-2 lg:py-2 lg:px-4 rounded-md shadow-lg transition-transform duration-300 hover:scale-110">
                    <span class="block text-xs md:text-xs lg:text-sm">Featured Deal</span>
                    <span class="block font-bold text-xs md:text-xs lg:text-sm">RTX 4090</span>
                </div>
                <div class="absolute bottom-6 left-2 bg-purple-700 text-white py-1 px-3 md:py-1 md:px-2 lg:py-2 lg:px-4 rounded-md shadow-lg transition-transform duration-300 hover:scale-110">
                    <span class="block font-bold text-xs md:text-xs lg:text-sm">FREE SHIPPING</span>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Marquee Section -->
<section class="py-20 bg-white" >

    <div class="bg-white pb-10 text-center">        
        <p class="text-sm text-gray-400">Meet the Dedicated Members of Our Project Team</p>
    </div>
    

    <div class="wrapper">
        <div class="marquee-track">
            <div class="marquee-content">
                <span class="item">John Eric Tayag</span>
                <span class="divider">/</span>
                <span class="item">Jan Mark Denzel Isip</span>
                <span class="divider">/</span>
                <span class="item">Jonathan Seromines</span>
                <span class="divider">/</span>
                <span class="item">David Jan Ramos</span>
                <span class="divider">/</span>
                <span class="item">Kevin Reyes</span>
                <span class="divider">/</span>
                <span class="item">Lougie Macasaquit</span>
                <span class="divider">/</span>
                <span class="item">Renzo Cunanan</span>
                <span class="divider">/</span>
                <span class="item">Clark</span>
                <span class="divider">/</span>
            </div>

            <!-- Duplicate for seamless scrolling -->
            <div class="marquee-content">
                <span class="item">John Eric Tayag</span>
                <span class="divider">/</span>
                <span class="item">Jan Mark Denzel Isip</span>
                <span class="divider">/</span>
                <span class="item">Jonathan Seromines</span>
                <span class="divider">/</span>
                <span class="item">David Jan Ramos</span>
                <span class="divider">/</span>
                <span class="item">Kevin Reyes</span>
                <span class="divider">/</span>
                <span class="item">Lougie Macasaquit</span>
                <span class="divider">/</span>
                <span class="item">Renzo Cunanan</span>
                <span class="divider">/</span>
                <span class="item">Clark</span>
                <span class="divider">/</span>
            </div>
        </div>
    </div>
</section>

    <!-- Featured Products -->
<section id="products" class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-4 py-1.5 rounded-full">TOP PICKS</span>
            <h3 class="text-3xl font-bold mt-3">Fan Favorites</h3>
            <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
                Handpicked by our tech enthusiasts for exceptional performance and value.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product Cards -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition group">
                <div class="relative overflow-hidden rounded-lg mb-4">
                    <span class="absolute top-2 right-2 bg-red-500 text-white text-base font-bold px-3 py-1.5 rounded z-10">SALE</span>

                    <img src="{{asset('images/gpu.png')}}" alt="GPU" class="transform group-hover:scale-105 transition duration-300">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-xl font-semibold">Legendary GPU X1</h4>
                        <div class="flex items-center mt-1 text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            <span class="text-gray-500 text-sm ml-1">(128)</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 line-through">$599.99</p>
                        <p class="text-xl font-bold text-blue-600">$499.99</p>
                    </div>
                </div>
                <ul class="text-sm text-gray-600 mt-3 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-1"></i> 16GB GDDR6X Memory</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> Ray Tracing Enabled</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> 3-Year Warranty</li>
                </ul>
                <button class="w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </div>
            
            <!-- Repeated Product Cards (SSD & Keyboard) -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition group">
                <div class="relative overflow-hidden rounded-lg mb-4">
                    <span class="absolute top-2 right-2 bg-green-500 text-white text-base font-bold px-3 py-1.5 rounded z-10">BEST VALUE</span>
                    <img src="{{asset('images/ssd.png')}}" alt="SSD" class="transform group-hover:scale-105 transition duration-300">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-xl font-semibold">Epic SSD 2TB</h4>
                        <div class="flex items-center mt-1 text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-gray-500 text-sm ml-1">(95)</span>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-blue-600">$199.99</p>
                </div>
                <ul class="text-sm text-gray-600 mt-3 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-1"></i> 7000MB/s Read Speed</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> Heat Dissipation Technology</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> 5-Year Warranty</li>
                </ul>
                <button class="w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition group">
                <div class="relative overflow-hidden rounded-lg mb-10">
                    <span class="absolute top-2 right-2 bg-purple-500 text-white text-base font-bold px-3 py-1.5 rounded z-10">NEW</span>
                    <img src="{{asset('images/keyboard.png')}}" alt="Keyboard" class="transform group-hover:scale-105 transition duration-300">
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-xl font-semibold">Mythic Keyboard Pro</h4>
                        <div class="flex items-center mt-1 text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="far fa-star"></i>
                            <span class="text-gray-500 text-sm ml-1">(42)</span>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-blue-600">$129.99</p>
                </div>
                <ul class="text-sm text-gray-600 mt-3 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-1"></i> RGB Backlit Keys</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> Mechanical Switches</li>
                    <li><i class="fas fa-check text-green-500 mr-1"></i> Programmable Macros</li>
                </ul>
                <button class="w-full mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                View All Products <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>


    <!-- Banner -->
    <section class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold">Limited Time Offer</h3>
                    <p class="text-gray-300 mt-2">Get 15% off on all gaming peripherals with code: <span class="font-mono bg-blue-800 px-2 py-1 rounded">LEGEND15</span></p>
                </div>
                <a href="#" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition">Shop the Sale</a>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-4 py-1.5 rounded-full">WHY CHOOSE US</span>
                <h3 class="text-3xl font-bold mt-3">The Tech of Legends Advantage</h3>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">We're not just another tech store. Here's why thousands of customers trust us.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold">Lightning-Fast Shipping</h4>
                    <p class="text-gray-600 mt-2">Free 2-day shipping on orders over $99. Same-day delivery available.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold">Secure Payments</h4>
                    <p class="text-gray-600 mt-2">Advanced encryption and multiple payment options for your security.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-medal text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold">Quality Guaranteed</h4>
                    <p class="text-gray-600 mt-2">All products undergo rigorous quality testing before shipping.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl text-center hover:shadow-lg transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-semibold">24/7 Support</h4>
                    <p class="text-gray-600 mt-2">Technical assistance and customer service available round the clock.</p>
                </div>
            </div>
            
            <div class="mt-12 p-6 bg-blue-50 rounded-xl">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/4 mb-4 md:mb-0 text-center">
                        <i class="fas fa-undo-alt text-blue-600 text-5xl"></i>
                    </div>
                    <div class="md:w-3/4">
                        <h4 class="text-xl font-semibold">30-Day Money-Back Guarantee</h4>
                        <p class="text-gray-600 mt-2">Not satisfied with your purchase? Return it within 30 days for a full refund, no questions asked. We're that confident in our product quality.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-4 py-1.5 rounded-full">TESTIMONIALS</span>
                <h3 class="text-3xl font-bold mt-3">What Our Customers Say</h3>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">Hear from gamers, creators, and IT professionals who've upgraded with Tech of Legends.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic">"Fast shipping and amazing quality! My gaming rig has never been better. The customer service team went above and beyond when I had questions about compatibility."</p>
                    <div class="mt-4 flex items-center">
                        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold">Alex G.</p>
                            <p class="text-sm text-gray-500">Professional Gamer</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic">"Tech of Legends saved my business with reliable parts and great support. We needed to upgrade our entire office hardware, and they made the process painless with bulk ordering and installation guidance."</p>
                    <div class="mt-4 flex items-center">
                        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold">Sarah T.</p>
                            <p class="text-sm text-gray-500">IT Manager</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 italic">"As a content creator, I need reliable gear that can handle heavy video editing. The Legendary GPU X1 has cut my rendering time in half! Highly recommend Tech of Legends for anyone in creative fields."</p>
                    <div class="mt-4 flex items-center">
                        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold">Michael R.</p>
                            <p class="text-sm text-gray-500">Video Producer</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                    Read More Reviews <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-4 py-1.5 rounded-full">FAQ</span>
                <h3 class="text-3xl font-bold mt-3">Frequently Asked Questions</h3>
                <p class="text-gray-600 mt-3 max-w-2xl mx-auto">Everything you need to know about our products and services.</p>
            </div>
            
            <div class="max-w-3xl mx-auto divide-y divide-gray-200">
                <div class="py-4">
                    <details class="group">
                        <summary class="flex justify-between items-center font-semibold cursor-pointer">
                            <span>How long does shipping take?</span>
                            <span class="transition group-open:rotate-180">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fade-in">For standard shipping, orders typically arrive within 3-5 business days. Premium members and orders over $99 qualify for free 2-day shipping. We also offer expedited shipping options at checkout.</p>
                    </details>
                </div>
                
                <div class="py-4">
                    <details class="group">
                        <summary class="flex justify-between items-center font-semibold cursor-pointer">
                            <span>What is your return policy?</span>
                            <span class="transition group-open:rotate-180">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fade-in">We offer a 30-day money-back guarantee on all products. If you're not satisfied, you can return any item in its original condition for a full refund or exchange. Simply contact our support team to initiate the process.</p>
                    </details>
                </div>
                
                <div class="py-4">
                    <details class="group">
                        <summary class="flex justify-between items-center font-semibold cursor-pointer">
                            <span>Do you offer product warranties?</span>
                            <span class="transition group-open:rotate-180">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fade-in">Yes, all our products come with manufacturer warranties ranging from 1 to 5 years depending on the item. We also offer extended warranty options at checkout for additional peace of mind.</p>
                    </details>
                </div>
                
                <div class="py-4">
                    <details class="group">
                        <summary class="flex justify-between items-center font-semibold cursor-pointer">
                            <span>How can I track my order?</span>
                            <span class="transition group-open:rotate-180">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fade-in">Once your order ships, you'll receive a tracking number via email. You can also view order status and tracking information in your account dashboard. Our mobile app offers real-time notifications on order updates.</p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-800 text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0 md:w-1/2">
                    <h3 class="text-3xl font-bold mb-4">Stay in the Loop</h3>
                    <p class="text-lg mb-6">Join our community to receive exclusive deals, early access to new products, and tech tips from our experts.</p>
                    <div class="flex items-center">
                        <i class="fas fa-lock mr-2"></i>
                        <p class="text-sm">We respect your privacy. Unsubscribe anytime.</p>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <form class="bg-white p-2 rounded-lg flex flex-col sm:flex-row">
                        <input type="email" placeholder="Enter your email" class="flex-grow p-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2 sm:mb-0 sm:mr-2">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition whitespace-nowrap">
                            <i class="fas fa-paper-plane mr-2"></i> Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer / Contact -->
    <footer id="contact" class="bg-gray-900 text-white pt-12 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <img src="{{asset('images/logo.png')}}" alt="Tech Legends Logo" class="h-10">
                    </div>
                    <p class="text-gray-400 mb-4">Empowering gamers, creators, and professionals with cutting-edge technology since 2018.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-blue-600 h-10 w-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-blue-600 h-10 w-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-blue-600 h-10 w-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-blue-600 h-10 w-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Products</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Support Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Return Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Shipping Info</a></li>
                        
                            <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Shipping Info</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right mr-2 text-sm"></i>Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-400"></i>
                            <span class="text-gray-400">123 Tech Boulevard, Silicon Valley, CA 94043</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-blue-400"></i>
                            <span class="text-gray-400">(555) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-400"></i>
                            <a href="mailto:support@techoflegends.com" class="text-gray-400 hover:text-white transition">support@techoflegends.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-blue-400"></i>
                            <span class="text-gray-400">24/7 Customer Support</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-800 text-center">        
                <p class="text-sm text-gray-500">&copy; 2025 Tech Legends. All rights reserved.</p>
                <p class="text-xs text-gray-600 mt-2">Designed by John Eric Tayag</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition opacity-0">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Custom Animation and Scripts -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        details > summary {
            list-style: none;
        }
        details > summary::-webkit-details-marker {
            display: none;
        }
    </style>
    
    <script>
        // Back to Top Button
        window.addEventListener('scroll', function() {
            const backToTopButton = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTopButton.style.opacity = '1';
            } else {
                backToTopButton.style.opacity = '0';
            }
        });
        
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
    </script>
</body>
</html>