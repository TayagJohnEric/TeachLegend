<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout - Secure Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-up': 'slideUp 0.3s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8 pb-6 border-b-2 border-gray-100">
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                            <i class="fas fa-credit-card text-blue-600"></i>
                            Secure Checkout
                        </h1>
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i>
                            SSL Secured
                        </div>
                    </div>

                    <!-- Success and Error Messages -->
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                                <span class="font-semibold">Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 ml-6">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.checkout.process') }}" class="space-y-8">
                        @csrf

                        <!-- Shipping Address Section -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                                <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
                                <h3 class="text-xl font-semibold text-gray-900">Shipping Address</h3>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="shipping_address" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-blue-500"></i>
                                    Delivery Address
                                </label>
                                <input 
                                    type="text" 
                                    id="shipping_address" 
                                    name="shipping_address" 
                                    class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50 focus:bg-white text-gray-900"
                                    placeholder="Enter your complete shipping address"
                                    value="{{ old('shipping_address') }}"
                                    required>
                            </div>
                        </div>

                        <!-- Payment Method Section -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                                <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                                <h3 class="text-xl font-semibold text-gray-900">Payment Method</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <!-- Credit Card Option -->
                                <label class="payment-option block cursor-pointer">
                                    <input type="radio" name="payment_method" value="credit_card" class="sr-only peer" {{ old('payment_method') == 'credit_card' || !old('payment_method') ? 'checked' : '' }}>
                                    <div class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300 group">
                                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl text-white mr-4">
                                            <i class="fas fa-credit-card text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900">Credit Card</div>
                                            <div class="text-sm text-gray-600">Visa, Mastercard, American Express</div>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-blue-500 peer-checked:bg-blue-500 relative">
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- PayPal Option -->
                                <label class="payment-option block cursor-pointer">
                                    <input type="radio" name="payment_method" value="paypal" class="sr-only peer" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                    <div class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300">
                                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl text-white mr-4">
                                            <i class="fab fa-paypal text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900">PayPal</div>
                                            <div class="text-sm text-gray-600">Fast and secure payment</div>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-blue-500 peer-checked:bg-blue-500 relative">
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Cash on Delivery Option -->
                                <label class="payment-option block cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod" class="sr-only peer" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                    <div class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300">
                                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white mr-4">
                                            <i class="fas fa-hand-holding-usd text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900">Cash on Delivery</div>
                                            <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-blue-500 peer-checked:bg-blue-500 relative">
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Hidden PC Build ID -->
                        @if($pcBuild)
                            <input type="hidden" name="pc_build_id" value="{{ $pcBuild->id }}">
                        @endif

                        <!-- Place Order Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-lock"></i>
                            Place Order Securely
                        </button>
                        
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-600 flex items-center justify-center gap-2">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                Your payment information is encrypted and secure. We never store your payment details.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-8 animate-fade-in">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-receipt text-blue-600"></i>
                        Order Summary
                    </h3>

                    <!-- Cart Items -->
                    @if(!$cartItems->isEmpty())
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-shopping-cart text-blue-500"></i>
                                Cart Items
                            </h4>
                            <ul class="space-y-3">
                                @foreach ($cartItems as $item)
                                    <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                        <div class="flex-1">
                                            <span class="font-medium text-gray-900">{{ $item->product->name }}</span>
                                            <span class="text-gray-600 ml-2">(x{{ $item->quantity }})</span>
                                        </div>
                                        <span class="font-semibold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- PC Build Summary -->
                    @if($pcBuild)
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-desktop text-blue-500"></i>
                                PC Build
                            </h4>
                            
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl mb-4 border border-blue-100">
                                <p class="font-semibold text-blue-800">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    Budget: ${{ number_format($pcBuild->budget, 2) }}
                                </p>
                            </div>
                            
                            <ul class="space-y-3">
                                @foreach ($selectedProducts as $product)
                                    <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                                        <span class="font-semibold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Total Amount -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border-2 border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($totalAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced payment method selection with animations
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-option').forEach(option => {
                    const div = option.querySelector('div');
                    div.style.transform = 'scale(1)';
                });
                
                if (this.checked) {
                    const selectedDiv = this.closest('.payment-option').querySelector('div');
                    selectedDiv.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        selectedDiv.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        });

        // Form submission with loading state
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing Order...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        });

        // Add hover effects to payment cards
        document.querySelectorAll('.payment-option').forEach(option => {
            const div = option.querySelector('div');
            
            option.addEventListener('mouseenter', function() {
                if (!this.querySelector('input').checked) {
                    div.style.transform = 'translateY(-2px)';
                    div.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                }
            });
            
            option.addEventListener('mouseleave', function() {
                div.style.transform = 'translateY(0)';
                div.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>