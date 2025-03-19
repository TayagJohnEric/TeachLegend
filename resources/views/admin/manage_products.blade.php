@extends('layouts.admin.app')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-[112rem]">
    <!-- Add Product Button -->
    <div class="mb-4">
        <button type="button" onclick="openProductModal()" class="text-sm px-4 py-3 bg-white text-gray-700 rounded-md border border-gray-200 hover:border-2 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
            Add New Product
        </button>
        <button type="button" onclick="openCategoryModal()" class="text-sm px-4 py-3 bg-white text-gray-700 rounded-md border border-gray-200 hover:border-2 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
            Add New Category
        </button>
    </div>
    
<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-overlay"></div>

    <!-- Modal Container -->
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white modal-container">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Product</h3>
            <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <input type="hidden" name="product_id" id="product_id">

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12  focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12  focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" step="0.01" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" id="stock" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12  focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full  px-4 py-3 h-12 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div id="imagePreview" class="mt-2 hidden">
                            <img src="" alt="Product Image" id="previewImage" class="w-24 h-24 object-cover rounded-md">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-24  focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3"></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Compatibility Data (JSON)</label>
                        <textarea name="compatibility_data" id="compatibility_data" class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-24  focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" onclick="closeProductModal()" class="px-4 py-3 bg-gray-200 text-gray-700 text-sm rounded-lg mr-2 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Cancel</button>
                <button type="submit" class="px-4 py-3 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">Save Product</button>
            </div>
        </form>
    </div>
</div>



  <!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-overlay"></div>

    <!-- Modal Container -->
    <div class="relative top-20 mx-auto p-5 border w-11/12 sm:w-3/4 md:w-1/2 lg:max-w-md shadow-lg rounded-md bg-white modal-container" onclick="event.stopPropagation()">
        <div class="flex items-start justify-between border-b pb-3">
            <h3 class="text-xl font-semibold text-gray-900" id="deleteModalTitle">
                Confirm Delete
            </h3>
            <button type="button" onclick="closeDeleteModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div class="py-4">
            <p class="text-gray-600">Are you sure you want to delete this product? This action cannot be undone.</p>
            <p class="font-medium text-gray-800 mt-2" id="productToDelete"></p>
        </div>

        <div class="flex items-center justify-end space-x-2 pt-3 border-t mt-2">
            <button type="button" onclick="closeDeleteModal()" class="text-sm px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Cancel
            </button>
            <form id="deleteProductForm" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>




<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-overlay"></div>

    <!-- Modal Container -->
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white modal-container">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Edit Product</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="edit_name"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="edit_category_id"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" id="edit_price"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="edit_stock"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-24 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        rows="3"></textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="edit_image"
                        class="mt-1 block w-full px-4 py-3 h-12 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <div id="current_image" class="mt-2"></div>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Compatibility Data</label>
                    <textarea name="compatibility_data" id="edit_compatibility_data"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-24 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        rows="3"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-3 bg-gray-200 text-gray-700 text-sm rounded-lg mr-2 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-3 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>






 <!-- Category Modal -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity modal-overlay"></div>

    <!-- Modal Container -->
    <div class="relative top-20 mx-auto p-5 border w-11/12 sm:w-3/4 md:w-1/2 lg:max-w-md shadow-lg rounded-lg bg-white modal-container">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900" id="categoryModalTitle">Add New Category</h3>
            <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
            @csrf
            <input type="hidden" name="category_id" id="edit_category_id">

            <div class="px-6 py-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="category_name"
                        class="mt-1 block w-full border border-gray-200 rounded-lg px-4 py-3 h-12 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required>
                    <p class="mt-1 text-sm text-gray-500">Category name must be unique</p>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-3 bg-gray-200 text-gray-700 text-sm rounded-lg mr-2 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-3 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>




    
    <!-- Product Table -->
    <div class="mt-4 bg-white rounded-lg shadow-md shadow-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Product List</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compatibility</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-8 h-8 object-cover rounded-md mr-3">
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-md mr-3 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No img</span>
                                    </div>
                                @endif
                                <span class="text-sm text-gray-700 truncate max-w-[120px]">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate text-sm text-gray-700">{{ $product->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate text-sm text-gray-700">
                            @if($product->compatibility_data)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Has data</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <!-- Edit Button with Icon -->
                            <button onclick="editProduct({{ $product->id }})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-500 bg-blue-100 hover:bg-blue-200  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-100">
                                <i class="fas fa-edit"></i>
                            </button>
                        
                            <!-- Delete Button with Icon -->
                            <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-100">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('modal-active'), 10); // Small delay for smooth animation
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('modal-active');
    setTimeout(() => modal.classList.add('hidden'), 300); // Wait for animation to finish
}
function openProductModal() {
    const modal = document.getElementById('productModal');

    // Remove "hidden" so the modal is visible
    modal.classList.remove('hidden');

    // Small delay to allow animation to trigger
    setTimeout(() => modal.classList.add('modal-active'), 10);

    // Reset form fields
    document.getElementById('modalTitle').textContent = 'Add New Product';
    document.getElementById('productForm').reset();
    document.getElementById('product_id').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
}

function closeProductModal() {
    const modal = document.getElementById('productModal');

    // Remove the "modal-active" class to trigger the closing animation
    modal.classList.remove('modal-active');

    // Wait for the animation to finish before hiding the modal
    setTimeout(() => modal.classList.add('hidden'), 300); // Match transition duration
}


function openCategoryModal(categoryId = null, categoryName = '') {
    const modal = document.getElementById('categoryModal');
    const modalTitle = document.getElementById('categoryModalTitle');

    modalTitle.textContent = categoryId ? 'Edit Category' : 'Add New Category';

    document.getElementById('edit_category_id').value = categoryId || '';
    document.getElementById('category_name').value = categoryName || '';

    // Remove "hidden" so the modal is visible
    modal.classList.remove('hidden');

    // Small delay to allow animation to trigger
    setTimeout(() => modal.classList.add('modal-active'), 10);

    // Prevent background scrolling
    document.body.style.overflow = 'hidden';
    document.getElementById('category_name').focus();
}

function closeCategoryModal() {
    const modal = document.getElementById('categoryModal');

    // Remove "modal-active" to start fade-out animation
    modal.classList.remove('modal-active');

    // Wait for animation to finish before hiding the modal
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('categoryForm').reset();
    }, 300); // Match CSS transition duration
}


   

    // Image Preview Before Upload
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('previewImage').src = event.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Close Modal When Clicking Outside
    document.getElementById('productModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeProductModal();
        }
    });


    function editProduct(productId) {
    const modal = document.getElementById('editProductModal');

    // Set the form action URL
    document.getElementById('editProductForm').action = `/admin/products/${productId}`;

    // Show modal with smooth animation
    modal.classList.remove('hidden');
    setTimeout(() => modal.classList.add('modal-active'), 10);

    // Fetch the product data and populate the form
    fetch(`/admin/products/${productId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_category_id').value = data.category_id;
            document.getElementById('edit_price').value = data.price;
            document.getElementById('edit_stock').value = data.stock;
            document.getElementById('edit_description').value = data.description;
            document.getElementById('edit_compatibility_data').value = data.compatibility_data;

            // Display current image if available
            if (data.image) {
                document.getElementById('current_image').innerHTML = `
                    <div class="flex items-center">
                        <img src="/storage/${data.image}" alt="${data.name}" class="h-16 w-16 object-cover rounded">
                        <span class="ml-2 text-xs text-gray-500">Current image (upload a new one to replace)</span>
                    </div>
                `;
            } else {
                document.getElementById('current_image').innerHTML = '<span class="text-xs text-gray-500">No current image</span>';
            }
        })
        .catch(error => {
            console.error('Error fetching product data:', error);
            alert('Failed to load product data. Please try again.');
            closeEditModal();
        });
}

function closeEditModal() {
    const modal = document.getElementById('editProductModal');

    // Trigger fade-out animation
    modal.classList.remove('modal-active');

    // Wait for animation to finish before hiding modal
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('editProductForm').reset();
    }, 300);
}



function confirmDelete(productId, productName) {
    // Set the product name in the modal
    document.getElementById('productToDelete').textContent = productName;

    // Set up the form action
    const deleteForm = document.getElementById('deleteProductForm');
    deleteForm.action = `/admin/products/${productId}`;

    // Show the modal with animation
    const deleteModal = document.getElementById('deleteConfirmModal');
    deleteModal.classList.remove('hidden');

    // Small delay to trigger fade-in animation
    setTimeout(() => deleteModal.classList.add('modal-active'), 10);

    // Prevent background scrolling
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const deleteModal = document.getElementById('deleteConfirmModal');

    // Remove "modal-active" to start fade-out animation
    deleteModal.classList.remove('modal-active');

    // Wait for animation to finish before hiding modal
    setTimeout(() => {
        deleteModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}


// Close modal when clicking outside
document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
   

        // Close modal when clicking outside the modal box
        window.addEventListener("click", function (event) {
            if (event.target === deleteModal) {
                deleteModal.classList.add("hidden");
            }
        });
</script>


@endsection