@extends('layouts.customer.app')

@section('title', 'All Products')


@section('content')
<div class="min-h-screen p-4 md:p-6 lg:p-8">
    <div class="max-w-[85rem] mx-auto">
        <!-- Promotional Banner -->
        <div class="w-full bg-blue-600 text-white h-[100px] flex items-center justify-center text-lg font-bold shadow-md rounded-lg mb-6">
            🎉 Limited Time Offer: Up to <span class="text-yellow-300 mx-1">50% OFF</span> + Free Shipping! 🚚
        </div>

        <!-- Main content with sidebar layout -->
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Products Content -->
            <div class="w-full order-1 lg:order-2">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        All Products
                    </h1>
                    
                    <!-- Filter and Sort Options -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <select id="category-filter" class="w-full sm:w-auto border border-gray-300 rounded-md p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="{{ route('products.index') }}">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ route('products.index', ['category' => $category->id]) }}"
                                    {{ request()->get('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select id="sort-order" class="w-full sm:w-auto border border-gray-300 rounded-md p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="newest" {{ request()->get('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request()->get('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request()->get('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request()->get('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ request()->get('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid - Modified to show 2 products per row on mobile -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                    @forelse ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-transform duration-300 hover:shadow-xl hover:scale-105 relative cursor-pointer" 
                    onclick="showProductModal({{ $product->id }})">
                   
                   <div class="relative pt-[100%]">
                       <!-- Product Image -->
                       <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                           alt="{{ $product->name }}" 
                           class="absolute inset-0 w-full h-full object-contain p-2">
               
                       <!-- Product Badges -->
                       @if($product->created_at->diffInDays(now()) < 7)
                           <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-md">NEW</span>
                       @endif
               
                       @if(isset($product->discount_percent) && $product->discount_percent > 0)
                           <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">
                               -{{ $product->discount_percent }}%
                           </span>
                       @endif
                   </div>
               
                   <div class="p-3 sm:p-4">
                       <!-- Category -->
                       <div class="text-xs text-gray-500 mb-1">
                           {{ $product->category->name }}
                       </div>
               
                       <!-- Product Name -->
                       <h3 class="text-gray-900 font-semibold text-sm sm:text-base md:text-lg mb-1 line-clamp-1">
                           {{ $product->name }}
                       </h3>
               
                       <!-- Product Description - Hidden on smallest screens -->
                       <p class="hidden sm:block text-gray-500 text-xs md:text-sm mb-2 line-clamp-2">
                           {{ Str::limit($product->description, 30, '...') }}
                       </p>
               
                       <!-- Product Price -->
                       <div class="flex items-center mb-2 sm:mb-3">
                           @if(isset($product->sale_price) && $product->sale_price < $product->price)
                               <span class="text-gray-900 font-bold text-sm sm:text-base md:text-lg">
                                   ${{ number_format($product->sale_price, 2) }}
                               </span>
                               <span class="text-gray-500 line-through text-xs ml-1 sm:ml-2">
                                   ${{ number_format($product->price, 2) }}
                               </span>
                           @else
                               <span class="text-gray-900 font-bold text-sm sm:text-base md:text-lg">
                                   ${{ number_format($product->price, 2) }}
                               </span>
                           @endif
                       </div>
               
                       <!-- Stock Status -->
                       @if($product->stock <= 0)
                           <div class="text-red-500 text-xs mb-2 sm:mb-3">Out of stock</div>
                       @elseif($product->stock < 5)
                           <div class="text-orange-500 text-xs mb-2 sm:mb-3">Only {{ $product->stock }} left!</div>
                       @endif
               
                       <!-- Add to Cart (Prevents Modal Opening) -->
                       <form method="POST" action="{{ route('cart.add', $product->id) }}" onclick="event.stopPropagation();">
                           @csrf
                           <div class="hidden sm:flex items-center gap-2 mb-3">
                               <label for="quantity{{ $product->id }}" class="text-gray-700 text-sm font-semibold">Qty:</label>
                               <input type="number" name="quantity" id="quantity{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-12 sm:w-16 border border-gray-300 rounded-md text-center text-gray-700 p-1 focus:ring-blue-500 focus:border-blue-500">
                           </div>
               
                           <input type="hidden" name="quantity" value="1" class="sm:hidden">
               
                           <button type="submit" 
                                   class="w-full flex items-center justify-center gap-1 sm:gap-2 bg-blue-600 hover:bg-blue-700 text-white py-1 sm:py-2 px-2 sm:px-4 text-xs sm:text-sm rounded-md transition-colors duration-200 {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                   {{ $product->stock <= 0 ? 'disabled' : '' }}>
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                       d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                               </svg>
                               <span>{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}</span>
                           </button>
                       </form>
                   </div>
               </div>
               
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center p-8 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-gray-500 text-base sm:text-lg font-medium">No products available</p>
                            <p class="text-gray-400 text-xs sm:text-sm mt-1">Try adjusting your filters or check back later for new products</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 sm:mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md relative">
        <!-- Close (X) Button -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <h2 id="modalProductName" class="text-xl font-bold text-gray-800"></h2>
        <img id="modalProductImage" class="w-full h-48 object-contain my-3" src="" alt="">
        <p id="modalProductCategory" class="text-sm text-gray-600"></p>
        <p id="modalProductDescription" class="text-gray-700 mt-2"></p>
        <p id="modalProductPrice" class="text-lg font-bold text-blue-600 mt-3"></p>
        <p id="modalProductStock" class="text-sm text-red-500"></p>

        <button onclick="closeModal()" class="w-full bg-red-500 text-white py-2 mt-4 rounded-md hover:bg-red-600">
            Close
        </button>
    </div>
</div>




<!--Filter and Sort Order Script -->
<script>
     // Category filter change handler
     const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', function() {
                var selectedUrl = this.value;
                if (selectedUrl) {
                    window.location.href = selectedUrl;
                }
            });
        }
        
        // Sort order change handler
        const sortOrder = document.getElementById('sort-order');
        if (sortOrder) {
            sortOrder.addEventListener('change', function() {
                var currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('sort', this.value);
                window.location.href = currentUrl.toString();
            });
        }
</script>


<!-- Product Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.showProductModal = function(productId) {
            console.log('Opening modal for product:', productId);

            const modal = document.getElementById('productModal');
            if (!modal) {
                console.error('Modal element not found!');
                return;
            }

            document.getElementById('modalProductName').textContent = 'Loading...';
            modal.classList.remove('hidden');

            fetch(`/products/${productId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(product => {
                    document.getElementById('modalProductName').textContent = product.name;

                    const imgElement = document.getElementById('modalProductImage');
                    imgElement.src = product.image ? `/storage/${product.image}` : '/images/placeholder.png';
                    imgElement.alt = product.name;

                    document.getElementById('modalProductCategory').textContent = "Category: " + product.category.name;
                    document.getElementById('modalProductDescription').textContent = product.description || "No description available.";
                    document.getElementById('modalProductPrice').textContent = `Price: $${product.price}`;
                    document.getElementById('modalProductStock').textContent = product.stock > 0 ? `Stock: ${product.stock}` : "Out of stock";
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                    document.getElementById('modalProductName').textContent = 'Error Loading Product';
                    document.getElementById('modalProductDescription').textContent = 'There was an error loading the product details. Please try again.';
                });
        };

        window.closeModal = function() {
            const modal = document.getElementById('productModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        };
    });
</script>

@endsection