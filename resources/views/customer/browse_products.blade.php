@extends('layouts.customer.app')

@section('title', 'All Products')

<style>
    body {
        text-align: center;
        font-family: Arial, sans-serif;
    }

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
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-transform duration-300 hover:shadow-xl hover:scale-105">
                            <div class="relative pt-[100%]">
                                <!-- Product Image -->
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                    alt="{{ $product->name }}" 
                                    class="absolute inset-0 w-full h-full object-contain p-2">


                                    



<!-- View Icon Button -->
<button class="absolute bottom-2 right-2 bg-gray-700 text-white p-2 rounded-full hover:bg-gray-900 transition"
    onclick="openProductModal({{ $product->id }})">

    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2C8.13 2 4.62 4.13 2 7c2.62 2.87 6.13 5 10 5s7.38-2.13 10-5c-2.62-2.87-6.13-5-10-5zm0 14c-4.42 0-8.41-1.79-11.32-4.68A19.92 19.92 0 0 1 12 22a19.92 19.92 0 0 1 11.32-4.68C20.41 14.21 16.42 16 12 16z"></path>
    </svg>
</button>







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

                                <!-- Add to Cart - Simplified for mobile -->
                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <div class="hidden sm:flex items-center gap-2 mb-3">
                                        <label for="quantity_{{ $product->id }}" class="text-gray-700 text-sm font-semibold">Qty:</label>
                                        <input type="number" name="quantity" id="quantity_{{ $product->id }}" value="1" min="1" max="{{ $product->stock }}"
                                            class="w-12 sm:w-16 border border-gray-300 rounded-md text-center text-gray-700 p-1 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    
                                    <!-- Always include a hidden quantity of 1 for mobile view -->
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

<!-- Product Details Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50" data-product-id="">
    <div class="bg-white w-[90%] max-w-md p-6 rounded-lg shadow-lg relative">
        <!-- Close Button -->
        <button onclick="closeProductModal()" class="absolute top-3 right-3 text-gray-700 hover:text-red-500">
            &times;
        </button>

        <!-- Product Content -->
        <div id="modalContent">
            <h2 id="modalProductName" class="text-xl font-bold mb-2"></h2>
            <img id="modalProductImage" class="w-full h-40 object-contain mb-3">
            <p id="modalProductDescription" class="text-gray-600 text-sm mb-3"></p>
            <p class="text-lg font-semibold">
                Price: <span id="modalProductPrice" class="text-blue-600"></span>
            </p>

            <!-- Rating Display -->
            <div class="flex items-center mt-3">
                <span id="modalProductRating" class="text-yellow-500 text-lg font-bold"></span>
                <span class="ml-1 text-gray-500 text-sm">(out of 5)</span>
                <span id="modalTotalReviews" class="text-gray-500 text-sm ml-2"></span>
            </div>

            <!-- User Reviews -->
            <div id="reviewsContainer" class="mt-4 max-h-40 overflow-y-auto border-t pt-2">
                <!-- Reviews will be dynamically added here -->
            </div>

            <!-- Add Review Form -->
            <div class="mt-4">
                <h3 class="text-md font-semibold mb-2">Leave a Review</h3>
                <div class="stars mb-2">
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
                <textarea id="reviewText" class="w-full border p-2 rounded" placeholder="Write your review here..."></textarea>
                <button onclick="submitReview()" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                    Submit Review
                </button>
            </div>
        </div>
    </div>
</div>





<script>
    document.getElementById('category-filter').addEventListener('change', function() {
        var selectedUrl = this.value;
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    });

    document.getElementById('sort-order').addEventListener('change', function() {
        var currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('sort', this.value);
        window.location.href = currentUrl.toString();
    });

    function openProductModal(productId) {
    fetch(`/products/${productId}/details`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch product details');
            }
            return response.json();
        })
        .then(data => {
            if (data.product) {
                document.getElementById('modalProductName').textContent = data.product.name;
                document.getElementById('modalProductImage').src = data.product.image || '{{ asset("images/placeholder.png") }}';
                document.getElementById('modalProductDescription').textContent = data.product.description || 'No description available.';
                document.getElementById('modalProductPrice').textContent = `$${data.product.price}`;
                document.getElementById('modalProductRating').textContent = data.average_rating || 'N/A';
                document.getElementById('modalTotalReviews').textContent = `(${data.total_reviews || 0} reviews)`;

                let reviewsContainer = document.getElementById('reviewsContainer');
                reviewsContainer.innerHTML = '';
                if (data.reviews && data.reviews.length > 0) {
                    data.reviews.forEach(review => {
                        let reviewElement = `<div class="border-b py-2">
                            <p class="text-yellow-500">★ ${review.rating}</p>
                            <p class="text-gray-700">${review.review_text}</p>
                            <p class="text-sm text-gray-500">- User ${review.user_id}</p>
                        </div>`;
                        reviewsContainer.innerHTML += reviewElement;
                    });
                } else {
                    reviewsContainer.innerHTML = '<p class="text-gray-500 text-sm">No reviews yet.</p>';
                }

                // Set product ID in modal
                document.getElementById('productModal').setAttribute('data-product-id', productId);
                document.getElementById('productModal').classList.remove('hidden');
            } else {
                alert('Product details not found.');
            }
        })
        .catch(error => console.error('Error fetching product details:', error));
}

function submitReview() {
    let selectedRating = document.querySelector('input[name="rating"]:checked')?.value;
    let reviewText = document.getElementById('reviewText').value;
    let productId = document.getElementById('productModal').getAttribute('data-product-id'); // Get product ID from modal

    if (!selectedRating) {
        alert("Please select a star rating.");
        return;
    }

    if (!reviewText.trim()) {
        alert("Please write a review.");
        return;
    }

    fetch(`/products/${productId}/reviews`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ rating: selectedRating, review_text: reviewText })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to submit review');
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
        closeProductModal();
        openProductModal(productId); // Refresh modal with updated reviews
    })
    .catch(error => console.error('Error:', error));
}

function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
}

</script>




@endsection