@extends('layouts.customer.app')

@section('title', 'Custom PC Builder')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Custom PC Builder</h1>
    </div>

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
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white px-4 py-3">
                        <h3 class="text-xl font-semibold">Build Budget</h3>
                    </div>
                    <div class="p-4">
                        <div class="relative">
                            <input 
                                type="number" 
                                name="budget" 
                                class="w-full pl-3 pr-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Enter your budget" 
                                min="500" 
                                max="10000"
                                value="{{ old('budget', 1000) }}"
                                required
                            >
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Recommended range: $500 - $10,000</p>

                        {{-- Show error for budget input --}}
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
                        <p class="text-gray-600">Make sure you select at least 4 components.</p>
                    </div>
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
                                                class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Show error if no components are selected --}}
                @error('selected_components')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror

                {{-- Submit Button (Always Enabled) --}}
                <button 
                    type="submit" 
                    class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition-colors"
                >
                    Save PC Build
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
