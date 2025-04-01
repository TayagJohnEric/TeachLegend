@extends('layouts.customer.app')

@section('title', 'Custom PC Builder')

@section('content')

<style>
    .component-checkbox {
     width: 24px; /* Increase checkbox size */
     height: 24px;
     border: 2px solid #d1d5db; /* Light gray border */
     border-radius: 4px; /* Optional: Slight rounding */
     appearance: none; /* Remove default checkbox styles */
     background-color: white;
     cursor: pointer;
     display: inline-flex;
     align-items: center;
     justify-content: center;
 }
 
 .component-checkbox:checked {
     background-color: #2563eb; /* Blue background when checked */
     border-color: #2563eb;
     background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='white'%3E%3Cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 11.086l6.293-6.293a1 1 0 011.414 0z' clip-rule='evenodd'/%3E%3C/svg%3E");
     background-repeat: no-repeat;
     background-position: center;
     background-size: 23px; /* Increase checkmark size */
 }
 
 /* Sticky sidebar styles for all sidebars */
 .sticky-sidebar {
     position: sticky;
     top: 1rem;
     max-height: calc(100vh - 2rem);
     overflow-y: auto;
     display: flex;
     flex-direction: column;
     gap: 1rem;
 }
 
 /* Selected components container with scrollable area */
 .selected-components-container {
     max-height: 50vh;
     overflow-y: auto;
 }
 
 /* Space for mobile fixed button */
 @media (max-width: 1023px) {
     .page-bottom-padding {
         padding-bottom: 70px;
     }
 }

 /* Enhanced shadow styles */
 .enhanced-shadow {
     box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
 }
 </style>


<div class="container mx-auto px-2 py-3 sm:px-4 py-3">

    {{-- 🚨 General Error Handling (Top of Page) --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-800 px-4 py-3 rounded-lg mb-4">
            <strong class="font-bold">🚨 Oops! Some issues were found:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <div class="py-3">
        <p id="component-warning" class="bg-blue-100 text-xs md:text-sm text-blue-600 font-bold p-2 md:p-4 rounded-lg flex items-center gap-2 md:gap-3 hidden">
            <span class="bg-white text-blue-600 rounded-full p-1 md:p-2 flex items-center justify-center">
                <i class="fas fa-info-circle"></i>
            </span>
            Reminder: A CPU, RAM, and Storage are required!
        </p>
    </div>

    <form action="{{ route('pc-builder.store') }}" method="POST" class="page-bottom-padding">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
            
            {{-- 💰 Budget & Summary Sidebar - Left Side --}}
            <div class="lg:col-span-3 md:col-span-6 order-1 lg:order-1">
                <div class="sticky-sidebar">
                    
                    {{-- 💰 Budget Input --}}
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden m-1">
                        <div class="bg-white text-white px-3 py-2 md:px-4 md:py-3">
                            <h3 class="text-lg md:text-xl font-semibold text-gray-800">Build Budget</h3>
                        </div>
                        
                        <div class="px-3 py-2 md:px-4 md:py-3">
                            <p class="text-xs text-gray-500 pb-2">Budget range: $500 - $500,000</p>
                            <input 
                            type="number" 
                            name="budget" 
                            id="budget-input"
                            class="w-full pl-3 pr-3 py-2 border-2 border-gray-100 rounded-xl mb-3 focus:ring-2 focus:ring-blue-300 focus:border-blue-500" 
                            placeholder="Enter your budget" 
                            min="500" 
                            max="500000"
                            value="{{ old('budget', 500) }}" 
                            required
                            >
                            
                            {{-- Display budget validation errors here --}}
                            @error('budget')
                                <p class="text-red-600 text-sm mt-2">💰 {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
            
                    {{-- 🛠️ Build Summary --}}
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden m-1">
                        <div class="bg-white text-gray-800 px-3 py-2 md:px-4 md:py-3">
                            <h3 class="text-lg md:text-xl font-semibold">Build Summary</h3>
                        </div>
                        <div class="p-3 md:p-4 space-y-2">
                            <div class="grid grid-cols-2 text-gray-500 text-sm">
                                <p>Total Cost:</p>
                                <p id="total-cost" class="font-bold text-gray-700 text-right">$0.00</p>
                            </div>
                            <div class="grid grid-cols-2 text-gray-500 text-sm">
                                <p>Remaining Budget:</p>
                                <p id="remaining-budget" class="font-bold text-gray-700 text-right">$0.00</p>
                            </div>
                            
                            {{-- 🔧 Display Compatibility Warnings Here --}}
                            @error('selected_components')
                                <div class="bg-yellow-50 border border-yellow-400 text-yellow-800 px-3 py-2 md:px-4 md:py-3 rounded-lg mt-4">
                                    <strong class="font-bold">⚠️ Compatibility Issues Detected:</strong>
                                    <ul class="list-disc list-inside mt-2">
                                        @foreach ($errors->get('selected_components') as $error)
                                            <li>🔧 {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- ✅ Submit Button --}}
                    <button 
                        type="submit" 
                        id="save-build-btn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 text-white text-sm py-2 md:py-3 rounded-lg hover:bg-gray-800 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                    >
                        Save PC Build
                    </button>
                </div>
            </div>

            {{-- 🖥️ Components Selection - Middle --}}
            <div class="lg:col-span-6 md:col-span-12 space-y-4 md:space-y-6 order-3 lg:order-2">
                @foreach ($categories as $categoryName => $products)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-800 text-gray-800 px-3 py-2 md:px-4 md:py-3">
                            <h3 class="text-white text-lg md:text-xl font-semibold">{{ $categoryName }}</h3>
                        </div>
                        <div class="p-2 md:p-3 grid grid-cols-1 gap-2 md:grid-cols-3 md:gap-4">
                            @foreach ($products as $product)
                                <div class="border-2 border-gray-100 rounded-lg overflow-hidden md:max-w-[250px] hover:shadow-lg transition duration-200">
                                    <div class="flex sm:block">
                                        <div class="w-24 h-24 sm:w-full sm:h-auto flex-shrink-0">
                                            <img 
                                                src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-contain sm:max-h-40"
                                            />
                                        </div>
                                        <div class="flex-1 p-2 sm:p-3">
                                            <h4 class="font-semibold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base truncate">
                                                {{ $product->name }}
                                            </h4>
                                            <div class="flex justify-between items-center">
                                                <span class="text-blue-600 font-bold text-sm sm:text-base">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                                <input 
                                                    type="checkbox" 
                                                    name="selected_components[]" 
                                                    value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"  
                                                    data-category="{{ $categoryName }}"
                                                    class="component-checkbox"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 📋 Selected Components - Right Side --}}
            <div class="lg:col-span-3 md:col-span-6 order-2 lg:order-3">
                <div class="sticky-sidebar">
                    <div class="bg-white shadow-sm rounded-lg overflow-visible m-1 z-10">
                        <div class="bg-white px-3 py-2 md:px-4 md:py-3">
                            <h3 class="text-gray-800 text-lg md:text-xl font-semibold">Selected Components</h3>
                        </div>
                        <div class="p-3 md:p-4">
                            <div id="selected-components-list" class="selected-components-container space-y-2">
                                <p class="text-sm text-gray-500 italic">No components selected yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <!-- Mobile-only Save button that appears fixed at bottom -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white p-3 shadow-lg border-t z-50">
        <button 
            type="submit" 
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-800 text-white text-sm py-3 rounded-lg hover:bg-gray-800 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
            id="mobile-save-build-btn"
        >
            Save PC Build
        </button>
    </div>
</div>

<script>
 document.addEventListener("DOMContentLoaded", function () {
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

                // Extract product details
                const productContainer = checkbox.closest('.border-2');
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
            selectedComponentsList.innerHTML = `<p class="text-sm text-gray-500 italic">No components selected yet.</p>`;
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
            // Find the form and submit it
            document.querySelector('form').submit();
        });
    }

    // Initial call to update total cost and component validation on page load
    updateTotalCost();
});
</script>
@endsection