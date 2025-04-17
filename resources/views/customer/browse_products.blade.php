@extends('layouts.customer.app')

@section('title', 'All Products')


<style>
    .stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .stars input {
        display: none;
    }

    .stars label {
        font-size: 40px;
        color: gray;
        cursor: pointer;
        transition: color 0.2s;
    }

    .stars input:checked ~ label {
        color: gold;
    }

    .stars label:hover,
    .stars label:hover ~ label {
        color: gold;
    }
</style>


@section('content')
<div class="min-h-screen px-4 py-5">
    <div class="max-w-[85rem] mx-auto">
        <!-- Promotional Banner -->
        <div class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 text-white h-[100px] flex items-center justify-center text-lg font-bold shadow-md rounded-lg mb-6 hover:shadow-xl transition-shadow duration-300">
            🎉 Limited Time Offer: Up to <span class="text-yellow-300 mx-1">50% OFF</span> + Free Shipping! 🚚
        </div>

        <!-- Main content with sidebar layout -->
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Products Content -->
            <div class="w-full order-1 lg:order-2">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-700">
                        All Products
                    </h1>
                    
                    <!-- Filter and Sort Options -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <select id="category-filter"
                        class="w-full sm:w-auto  rounded-lg p-3 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out hover:border-blue-400">
                        <option value="{{ route('products.index') }}">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ route('products.index', ['category' => $category->id]) }}"
                                {{ request()->get('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select id="sort-order"
                        class="w-full sm:w-auto rounded-lg p-3 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out hover:border-blue-400">
                        <option value="newest" {{ request()->get('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request()->get('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request()->get('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request()->get('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="name_desc" {{ request()->get('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                    </select>
                    
                    </div>
                </div>

             <!-- Product Grid - Improved responsive grid with modern styling -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5 md:gap-6">
    @forelse ($products as $product)
    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg overflow-hidden transition-all duration-300 border border-gray-100 relative group" 
         onclick="showProductModal({{ $product->id }})">
        
        <!-- Image container with consistent aspect ratio -->
        <div class="relative pt-[100%] bg-gray-50 overflow-hidden">
            <!-- Product Image with hover zoom effect -->
            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                alt="{{ $product->name }}" 
                class="absolute inset-0 w-full h-full object-contain p-3 transition-transform duration-500 group-hover:scale-110">
            
            <!-- Discount badge with improved styling -->
            @if(isset($product->discount_percent) && $product->discount_percent > 0)
                <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">
                    -{{ $product->discount_percent }}%
                </span>
            @endif

            <!-- Quick view button appearing on hover -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="bg-white/90 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-full shadow-sm backdrop-blur-sm">
                    Quick View
                </span>
            </div>
        </div>
        
        <div class="p-3 sm:p-4 text-left">
            <!-- Category with subtle styling -->
            <div class="text-xs text-gray-500 font-medium mb-1">
                {{ $product->category->name }}
            </div>
            
            <!-- Product Name with improved typography -->
            <h3 class="text-gray-900 font-semibold text-sm sm:text-base line-clamp-1 mb-1 group-hover:text-blue-700 transition-colors">
                {{ $product->name }}
            </h3>
            
            <!-- Product Price with improved layout -->
            <div class="flex items-center mb-2 sm:mb-3">
                @if(isset($product->sale_price) && $product->sale_price < $product->price)
                    <span class="text-gray-900 font-bold text-sm sm:text-base">
                        ₱{{ number_format($product->sale_price, 2) }}
                    </span>
                    <span class="text-gray-400 line-through text-xs ml-2">
                        ₱{{ number_format($product->price, 2) }}
                    </span>
                @else
                    <span class="text-gray-900 font-bold text-sm sm:text-base">
                        ₱{{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>
            
            <!-- Stock Status with improved indicators -->
            @if($product->stock <= 0)
                <div class="flex items-center text-red-600 text-xs mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Out of stock
                </div>
            @elseif($product->stock < 5)
                <div class="flex items-center text-amber-600 text-xs mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Only {{ $product->stock }} left!
                </div>
            @else
                <div class="flex items-center text-green-600 text-xs mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    In Stock
                </div>
            @endif
            
            <!-- Add to Cart Button with improved styling and interaction -->
            <form method="POST" action="{{ route('cart.add', $product->id) }}" onclick="event.stopPropagation();">
                @csrf                 
                <button type="submit" 
                      class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white py-2 px-4 text-sm rounded-lg transition-all duration-200 shadow-sm {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-md' }}"
                      {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-medium">{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}</span>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-8">
        <p class="text-gray-500">No products found</p>
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



<!-- Product Modal with Scrollable Content -->
<div id="productModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-md relative max-h-[90vh] overflow-y-auto">
        
      <!-- Sticky Close Button -->
<div class="sticky top-0 bg-transparent z-10 flex justify-end p-2">
    <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
</div>

        <h2 id="modalProductName" class="text-xl font-bold text-gray-700"></h2>
        <img id="modalProductImage" class="w-full h-48 object-contain my-3" src="" alt="">
        <p id="modalProductCategory" class="text-sm text-gray-700"></p>
        <p id="modalProductDescription" class="text-gray-600 mt-2 text-sm"></p>
        <p id="modalProductPrice" class="text-lg font-bold text-blue-600 mt-3"></p>
        <p id="modalProductStock" class="text-sm text-red-500"></p>
       
        <form class="mt-4" action="{{ route('reviews.store') }}" method="POST">      
            @csrf
            <input type="hidden" id="modalProductId" name="product_id" value="">
            <label for="rating" class="text-gray-700">Rate this product:</label>
            <div class="stars">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>

                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>
                
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>
                
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>
                
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>

            <label for="review_text" class="text-gray-700">Leave a review:</label>
            <textarea name="review_text" id="review_text" class="w-full border border-gray-300 rounded-md p-2 text-sm focus:ring-blue-500 focus:border-blue-500 mt-1"></textarea>
            
            <button type="submit" class="w-full  bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-2 mt-4 rounded-md hover:bg-blue-600">
                Submit Review
            </button>
        </form>
        
        <div class="mt-6 mb-4">
            <h3 class="text-lg font-semibold border-b pb-2">Customer Reviews</h3>
            <div id="averageRating" class="flex items-center mt-2">
                <span class="text-yellow-400 text-xl mr-2">★</span>
                <span id="avgRatingValue">0.0</span>
                <span class="text-gray-500 text-sm ml-2">(<span id="reviewCount">0</span> reviews)</span>
            </div>
            <div id="reviewsContainer" class="mt-4 space-y-4">
                <!-- Reviews will be loaded here -->
                <div class="text-center text-gray-500" id="noReviewsMessage">Loading reviews...</div>
            </div>
            <div class="mt-3 flex justify-center" id="paginationContainer">
                <!-- Pagination controls will be here -->
            </div>
        </div>

        <form method="POST" action="{{ route('cart.add', $product->id) }}" onclick="event.stopPropagation();">
            @csrf                 
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-blue-700 text-white py-2 text-sm rounded-md transition-colors duration-200 {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}</span>
            </button>
        </form>
        
        <!-- Close Button (for reference) -->
        <button onclick="closeModal()" 
        class="w-full bg-white text-gray-800 border border-gray-200 py-2 text-sm rounded-md hover:border-1 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
    Close
</button>        
    </div>
</div>


<script>
    // Define the showProductModal function globally so it exists during page rendering
    function showProductModal(productId) {
        // This wrapper function will be available during HTML rendering
        // It will call the fully implemented version after the page loads
        if (window._showProductModalImpl) {
            window._showProductModalImpl(productId);
        } else {
            console.log('Modal implementation not loaded yet, product ID:', productId);
        }
    }
</script>



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
        // Implement the actual modal functionality
        window._showProductModalImpl = function(productId) {
            console.log('Opening modal for product:', productId);
            const modal = document.getElementById('productModal');
            if (!modal) {
                console.error('Modal element not found!');
                return;
            }
            document.getElementById('modalProductName').textContent = 'Loading...';
            modal.classList.remove('hidden');
            // Set the product ID in the hidden form field
            document.getElementById('modalProductId').value = productId;
            // Reset reviews section if it exists
            const reviewsContainer = document.getElementById('reviewsContainer');
            if (reviewsContainer) {
                reviewsContainer.innerHTML = '<div class="text-center text-gray-500" id="noReviewsMessage">Loading reviews...</div>';
            }
            
            // Rest of your existing implementation...
            if (document.getElementById('paginationContainer')) {
                document.getElementById('paginationContainer').innerHTML = '';
            }
            
            if (document.getElementById('avgRatingValue')) {
                document.getElementById('avgRatingValue').textContent = '0.0';
            }
            
            if (document.getElementById('reviewCount')) {
                document.getElementById('reviewCount').textContent = '0';
            }
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
                    document.getElementById('modalProductPrice').textContent = `Price: ₱${product.price}`;
                    document.getElementById('modalProductStock').textContent = product.stock > 0 ? `Stock: ${product.stock}` : "Out of stock";
                    
                    // Check if user has already reviewed this product
                    checkExistingReview(productId);
                    
                    // Fetch reviews for this product
                    fetchProductReviews(productId, 1);
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
                // Reset the review form
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            }
        };
        
        // Function to check if user has already reviewed this product
        function checkExistingReview(productId) {
            fetch(`/products/${productId}/reviews?user_only=true`)
                .then(response => {
                    if (!response.ok) {
                        // If not found or not authorized, just ignore
                        if (response.status === 404 || response.status === 401) {
                            return null;
                        }
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.review) {
                        // Pre-fill form with existing review data
                        const rating = data.review.rating;
                        const ratingInput = document.querySelector(`#star${rating}`);
                        if (ratingInput) {
                            ratingInput.checked = true;
                        }
                        
                        const reviewTextarea = document.getElementById('review_text');
                        if (reviewTextarea) {
                            reviewTextarea.value = data.review.review_text || '';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking existing review:', error);
                });
        }
        
        // Function to fetch product reviews using the regular web route
        function fetchProductReviews(productId, page = 1) {
            fetch(`/products/${productId}/reviews?page=${page}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    displayReviews(data, productId);
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    const noReviewsMessage = document.getElementById('noReviewsMessage');
                    if (noReviewsMessage) {
                        noReviewsMessage.textContent = 'Failed to load reviews.';
                    }
                });
        }
        
        // Function to display reviews
        function displayReviews(data, productId) {
            const reviewsContainer = document.getElementById('reviewsContainer');
            if (!reviewsContainer) return;
            
            reviewsContainer.innerHTML = '';
            
            // Display average rating and count
            if (data.data && data.data.length > 0) {
                // Calculate average rating if not provided by the API
                let totalRating = 0;
                data.data.forEach(review => {
                    totalRating += review.rating;
                });
                const avgRating = (totalRating / data.data.length).toFixed(1);
                
                if (document.getElementById('avgRatingValue')) {
                    document.getElementById('avgRatingValue').textContent = avgRating;
                }
                
                if (document.getElementById('reviewCount')) {
                    document.getElementById('reviewCount').textContent = data.total || data.data.length;
                }
            } else {
                reviewsContainer.innerHTML = '<div class="text-center text-sm text-gray-500">No reviews yet. Be the first to review!</div>';
                return;
            }
            
            // Display individual reviews
            data.data.forEach(review => {
                const reviewElement = document.createElement('div');
                reviewElement.className = 'border-b pb-3 mb-3';
                
                // Create stars based on rating
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= review.rating) {
                        stars += '<span class="text-yellow-400">★</span>';
                    } else {
                        stars += '<span class="text-gray-300">★</span>';
                    }
                }
                
                // Format date
                const reviewDate = new Date(review.created_at);
                const formattedDate = reviewDate.toLocaleDateString();
                
                reviewElement.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
<div class="font-medium">${review.user ? `${review.user.first_name} ${review.user.last_name}` : 'Anonymous'}</div>                            <div class="text-sm text-gray-500">${formattedDate}</div>
                        </div>
                        <div>${stars}</div>
                    </div>
                    <p class="mt-2 text-gray-700">${review.review_text || '(No comment)'}</p>
                `;
                
                reviewsContainer.appendChild(reviewElement);
            });
            
            // Add pagination if needed
            const paginationContainer = document.getElementById('paginationContainer');
            if (paginationContainer && data.last_page > 1) {
                createPagination(data, productId);
            }
        }
        
        // Function to create pagination controls
        function createPagination(data, productId) {
            const paginationContainer = document.getElementById('paginationContainer');
            if (!paginationContainer) return;
            
            paginationContainer.innerHTML = '';
            
            const paginationElement = document.createElement('div');
            paginationElement.className = 'flex space-x-1';
            
            // Previous button
            if (data.current_page > 1) {
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300';
                prevButton.addEventListener('click', () => {
                    fetchProductReviews(productId, data.current_page - 1);
                });
                paginationElement.appendChild(prevButton);
            }
            
            // Page numbers
            const startPage = Math.max(1, data.current_page - 2);
            const endPage = Math.min(data.last_page, startPage + 4);
            
            for (let i = startPage; i <= endPage; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i.toString();
                pageButton.className = i === data.current_page 
                    ? 'px-3 py-1 bg-blue-500 text-white rounded' 
                    : 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300';
                pageButton.addEventListener('click', () => {
                    fetchProductReviews(productId, i);
                });
                paginationElement.appendChild(pageButton);
            }
            
            // Next button
            if (data.current_page < data.last_page) {
                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300';
                nextButton.addEventListener('click', () => {
                    fetchProductReviews(productId, data.current_page + 1);
                });
                paginationElement.appendChild(nextButton);
            }
            
            paginationContainer.appendChild(paginationElement);
        }
    });
</script>

@endsection