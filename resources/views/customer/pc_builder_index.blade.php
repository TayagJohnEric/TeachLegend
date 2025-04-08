@extends('layouts.customer.app')
@section('title', 'Custom PC Builder')
@section('content')
<style>
    .component-checkbox {
        width: 24px;
        height: 24px;
        border: 2px solid #d1d5db;
        border-radius: 4px;
        appearance: none;
        background-color: white;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .component-checkbox:checked {
        background-color: #2563eb;
        border-color: #2563eb;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='white'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 11.086l6.293-6.293a1 1 0 011.414 0z' clip-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 23px;
    }
    
    .sticky-sidebar {
        position: sticky;
        top: 1rem;
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .selected-components-container {
        max-height: 50vh;
        overflow-y: auto;
    }
    
    @media (max-width: 1023px) {
        .page-bottom-padding {
            padding-bottom: 70px;
        }
    }
</style>
<div class="container mx-auto px-4 py-6">
    <!-- Error Handling Section -->
    @if ($errors->any())
    <div id="error-alert" class="mb-6">
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md text-sm text-red-700 relative">
            <span class="sr-only">Error list:</span>
            
            <div class="flex items-start gap-3">
                <span class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8.707-3.707a1 1 0 111.414 1.414L10.414 10l.293.293a1 1 0 11-1.414 1.414L9 11.414l-.293.293a1 1 0 01-1.414-1.414L8.586 10l-.293-.293a1 1 0 111.414-1.414L9 8.586l.293-.293z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <strong>🚨 Oops! Some issues were found:</strong>
            </div>
            
            <ul class="list-none pl-8 md:pl-10 mt-2">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center gap-2">
                        <span class="text-red-600">⚠️</span>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
            
            <button type="button" class="close-alert absolute top-2 right-2 text-red-600 hover:text-red-800 p-1">
                <span class="sr-only">Dismiss error message</span>
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Component Warning Message -->
    <div class="mb-6">
        <div id="component-warning" class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md flex items-start gap-3 relative text-sm text-blue-700">
            <span class="sr-only">Important reminder:</span>
            
            <span class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </span>
            
            <div class="flex-1">
                Reminder: A CPU, RAM, and Storage are required!
            </div>
            
            <button type="button" class="close-alert absolute top-2 right-2 text-blue-600 hover:text-blue-800 p-1">
                <span class="sr-only">Dismiss warning message</span>
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <form action="{{ route('pc-builder.store') }}" method="POST" class="pb-20 md:pb-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            
            <!-- Budget & Summary Section -->
            <div class="md:col-span-3 lg:col-span-3 order-1">
                <div class="space-y-4 sticky top-4">
                    <!-- Budget Input Card -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Build Budget</h3>
                        </div>
                        
                        <div class="px-4 py-4">
                            <p class="text-xs text-gray-500 pb-2">Budget range: $500 - $500,000</p>
                            <input 
                                type="number" 
                                name="budget" 
                                id="budget-input"
                                class="w-full px-3 py-2 border-2 border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-500" 
                                placeholder="Enter your budget" 
                                min="500" 
                                max="500000"
                                value="{{ old('budget', 500) }}" 
                                required
                            >
                            
                            @error('budget')
                                <p class="text-red-600 text-sm mt-2">💰 {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Build Summary Card -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Build Summary</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="grid grid-cols-2 text-gray-600 text-sm">
                                <p>Total Cost:</p>
                                <p id="total-cost" class="font-bold text-gray-700 text-right">$0.00</p>
                            </div>
                            <div class="grid grid-cols-2 text-gray-600 text-sm">
                                <p>Remaining Budget:</p>
                                <p id="remaining-budget" class="font-bold text-gray-700 text-right">$0.00</p>
                            </div>
                            
                            <!-- Compatibility Warnings -->
                            @error('selected_components')
                            <div class="mt-3">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-md text-sm text-yellow-700">
                                    <div class="flex items-start gap-2">
                                        <span class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.516 11.591c.75 1.334-.213 2.99-1.742 2.99H3.483c-1.53 0-2.492-1.656-1.743-2.99L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 112 0v2a1 1 0 01-1 1z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <strong>⚠️ Compatibility Issues:</strong>
                                    </div>
                                    <ul class="list-disc list-inside mt-2 pl-6">
                                        @foreach ($errors->get('selected_components') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Desktop Save Button -->
                    <button 
                        type="submit" 
                        id="save-build-btn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-3 rounded-lg hover:opacity-90 transition-opacity disabled:bg-gray-400 disabled:cursor-not-allowed hidden md:block"
                    >
                        Save PC Build
                    </button>
                </div>
            </div>
            
            <!-- Selected Components Section -->
            <div class="md:col-span-3 lg:col-span-3 order-2 md:order-3">
                <div class="sticky top-4">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Selected Components</h3>
                        </div>
                        <div class="p-4">
                            <div id="selected-components-list" class="space-y-3 min-h-40">
                                <p class="text-sm text-gray-500">No components selected yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Components Selection Section -->
            <div class="md:col-span-6 lg:col-span-6 order-3 md:order-2">
                <div class="space-y-6">
                    @foreach ($categories as $categoryName => $products)
                        <div class="bg-white shadow rounded-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-800 px-4 py-3">
                                <h3 class="text-white text-lg font-semibold">{{ $categoryName }}</h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($products as $product)
                                        <div class="border border-gray-100 rounded-lg overflow-hidden hover:shadow-md transition duration-200">
                                            <div class="flex flex-col h-full">
                                                <div class="h-40 bg-gray-50 flex items-center justify-center p-2">
                                                    <img 
                                                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                                        alt="{{ $product->name }}"
                                                        class="max-h-36 max-w-full object-contain"
                                                    />
                                                </div>
                                                <div class="p-3 flex flex-col flex-grow">
                                                    <h4 class="font-medium text-gray-800 mb-2 line-clamp-2">
                                                        {{ $product->name }}
                                                    </h4>
                                                    <div class="flex justify-between items-center mt-auto">
                                                        <span class="text-blue-600 font-bold">
                                                            ${{ number_format($product->price, 2) }}
                                                        </span>
                                                        <input 
                                                            type="checkbox" 
                                                            name="selected_components[]" 
                                                            value="{{ $product->id }}"
                                                            data-price="{{ $product->price }}"  
                                                            data-category="{{ $categoryName }}"
                                                            class="component-checkbox h-5 w-5 text-blue-600"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>

    <!-- Mobile Save Button (Fixed at Bottom) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white p-4 shadow-lg border-t z-50">
        <button 
            type="submit" 
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 text-white py-3 rounded-lg hover:opacity-90 transition-opacity disabled:bg-gray-400 disabled:cursor-not-allowed"
            id="mobile-save-build-btn"
        >
            Save PC Build
        </button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".close-alert").forEach(button => {
            button.addEventListener("click", function () {
                this.closest("div, p").remove(); // Removes the parent alert container
            });
        });

    const checkboxes = document.querySelectorAll('.component-checkbox');
    const totalCostDisplay = document.getElementById('total-cost');
    const remainingBudgetDisplay = document.getElementById('remaining-budget');
    const budgetInput = document.getElementById('budget-input');
    const selectedComponentsList = document.getElementById('selected-components-list');
    const componentWarning = document.getElementById('component-warning');
    const saveBuildBtn = document.getElementById('save-build-btn');
    const mobileSaveBuildBtn = document.getElementById('mobile-save-build-btn');
    
    function updateTotalCost() {
        let totalCost = 0;
        let hasCPU = false;
        let hasRAM = false;
        let hasStorage = false;
        let selectedCount = 0;
        
        selectedComponentsList.innerHTML = "";
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                const price = parseFloat(checkbox.dataset.price) || 0;
                totalCost += price;
                const category = checkbox.dataset.category;
                
                if (category.includes("CPU")) hasCPU = true;
                if (category.includes("RAM")) hasRAM = true;
                if (category.includes("Storage")) hasStorage = true;
                
                // Extract product details - Fixed to properly locate the parent container
                const productContainer = checkbox.closest('.border.border-gray-100');
                const productName = productContainer.querySelector('h4').textContent.trim();
                const productImage = productContainer.querySelector('img').src;
                
                // Append selected component to the list
                selectedComponentsList.innerHTML += `
                    <div class="flex items-center space-x-2 md:space-x-3 border p-2 rounded-lg bg-gray-100">
                        <img src="${productImage}" class="w-8 h-8 md:w-10 md:h-10 object-cover rounded" alt="${productName}">
                        <div class="flex-1 min-w-0">
                            <span class="block text-gray-800 font-semibold text-xs md:text-sm truncate">${productName}</span>
                            <span class="block text-xs text-gray-600">${category}</span>
                        </div>
                        <span class="text-xs text-blue-600 font-medium">$${price.toFixed(2)}</span>
                    </div>
                `;
            }
        });
        
        // Show placeholder text if no components selected
        if (selectedCount === 0) {
            selectedComponentsList.innerHTML = `<p class="text-sm text-gray-500">No components selected yet.</p>`;
        }
        
        // Update total cost display
        totalCostDisplay.textContent = `$${totalCost.toFixed(2)}`;
        
        const budget = parseFloat(budgetInput.value) || 0;
        const remainingBudget = budget - totalCost;
        
        // Update remaining budget display
        remainingBudgetDisplay.textContent = `$${Math.max(remainingBudget, 0).toFixed(2)}`;
        remainingBudgetDisplay.classList.toggle('text-red-500', remainingBudget < 0);
        remainingBudgetDisplay.classList.toggle('text-green-500', remainingBudget >= 0);
        
        // Show/hide warning if required components are missing
        componentWarning.classList.toggle("hidden", hasCPU && hasRAM && hasStorage);
        
        // Disable the save buttons if the budget is exceeded or required components are missing
        const disableSave = remainingBudget < 0 || !(hasCPU && hasRAM && hasStorage);
        saveBuildBtn.disabled = disableSave;
        if (mobileSaveBuildBtn) {
            mobileSaveBuildBtn.disabled = disableSave;
        }
    }
    
    // Event listeners for checkboxes and budget input
    checkboxes.forEach(checkbox => checkbox.addEventListener('change', updateTotalCost));
    budgetInput.addEventListener('input', updateTotalCost);
    
    // Sync the mobile save button with the main save button
    if (mobileSaveBuildBtn) {
        mobileSaveBuildBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('form').submit();
        });
    }
    
    // Initial call to update total cost and component validation on page load
    updateTotalCost();
});
</script>
@endsection