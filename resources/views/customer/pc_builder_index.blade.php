@extends('layouts.customer.app')

@section('title', 'Custom PC Builder')

@section('content')
<div class="container mx-auto px-4">
    {{-- Error Handling --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Oops! Some issues were found:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pc-builder.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            {{-- Budget and Summary Sidebar --}}
            <div class="md:col-span-1">
                <div class="space-y-6 md:sticky md:top-0">
                    {{-- Budget Input --}}
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-blue-600 text-white px-4 py-3">
                            <h3 class="text-xl font-semibold">Build Budget</h3>
                        </div>
                        <div class="p-4">
                            <input 
                                type="number" 
                                name="budget" 
                                id="budget-input"
                                class="w-full pl-3 pr-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Enter your budget" 
                                min="500" 
                                max="500000"
                                value="{{ old('budget', 500) }}" 
                                required
                            >
                            <p class="text-xs text-gray-500 mt-2">Budget range: $500 - $500,000</p>
                            @error('budget')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
            
                    {{-- Build Summary --}}
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-gray-200 text-gray-800 px-4 py-3">
                            <h3 class="text-xl font-semibold">Build Summary</h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <p class="text-gray-600">Total Cost: <span id="total-cost" class="font-bold text-blue-600">$0.00</span></p>
                            <p class="text-gray-600">Remaining Budget: <span id="remaining-budget" class="font-bold text-green-600">$0.00</span></p>
                            <p id="component-warning" class="text-red-600 font-bold hidden">⚠️ Warning: A CPU and GPU are required!</p>
                            <div id="selected-components-list" class="mt-3 space-y-2"></div>
                        </div>
                    </div>

                    {{-- Submit Button (Immediately Below Build Summary) --}}
                    <button 
                        type="submit" 
                        id="save-build-btn"
                        class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled
                    >
                        Save PC Build
                    </button>
                </div>
            </div>

            {{-- Components Selection --}}
            <div class="md:col-span-3 space-y-6">
                @foreach ($categories as $categoryName => $products)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="bg-blue-600 text-white px-4 py-3">
                            <h3 class="text-xl font-semibold">{{ $categoryName }}</h3>
                        </div>
                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($products as $product)
                                <div class="border rounded-lg overflow-hidden">
                                    <img 
                                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" 
                                        alt="{{ $product->name }}"
                                        class="w-full h-48 object-cover"
                                    >
                                    <div class="p-3">
                                        <h4 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h4>
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-600 font-bold">${{ number_format($product->price, 2) }}</span>
                                            <input 
                                                type="checkbox" 
                                                name="selected_components[]" 
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->price }}"  
                                                data-category="{{ $categoryName }}"
                                                class="component-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @error('selected_components')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </form>
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

        function updateTotalCost() {
    let totalCost = 0;
    let hasCPU = false;
    let hasGPU = false;
    selectedComponentsList.innerHTML = ""; 

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const price = parseFloat(checkbox.dataset.price);
            totalCost += price;

            const category = checkbox.dataset.category;
            if (category.includes("CPU")) hasCPU = true;
            if (category.includes("GPU")) hasGPU = true;

            const productName = checkbox.closest('.border').querySelector('h4').textContent;
            const productImage = checkbox.closest('.border').querySelector('img').src;

            const componentHTML = `
                <div class="flex items-center space-x-3 border p-2 rounded-lg bg-gray-100">
                    <img src="${productImage}" class="w-10 h-10 object-cover rounded" alt="${productName}">
                    <div>
                        <span class="block text-gray-800 font-semibold">${productName}</span>
                        <span class="block text-sm text-gray-600">${category}</span> <!-- Category Label -->
                    </div>
                </div>
            `;
            selectedComponentsList.innerHTML += componentHTML;
        }
    });

    totalCostDisplay.textContent = `$${totalCost.toFixed(2)}`;
    const budget = parseFloat(budgetInput.value) || 0;
    let remainingBudget = budget - totalCost;

    remainingBudgetDisplay.textContent = `$${Math.max(remainingBudget, 0).toFixed(2)}`;
    remainingBudgetDisplay.classList.toggle('text-red-600', remainingBudget < 0);
    remainingBudgetDisplay.classList.toggle('text-green-600', remainingBudget >= 0);

    componentWarning.classList.toggle("hidden", hasCPU && hasGPU);
    saveBuildBtn.disabled = remainingBudget < 0;
}


        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalCost);
        });
        budgetInput.addEventListener('input', updateTotalCost);

        updateTotalCost();
    });
</script>

@endsection
