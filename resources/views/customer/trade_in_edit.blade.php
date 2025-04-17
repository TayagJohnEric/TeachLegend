@extends('layouts.customer.app')

@section('title', 'Edit Trade-In Listing')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-4">
    <div class="w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    Edit Component Information
                </h2>
                <p class="text-gray-400">Update your component listing on our marketplace</p>
            </div>
            
            <div class="p-4">
                <form method="POST" action="{{ route('trade-in.update', $tradeIn) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- First row -->
                        <div class="md:col-span-4">
                            <label for="component_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Type <span class="text-red-500">*</span>
                            </label>
                            <select id="component_type" name="component_type" required
                                class="w-full px-3 py-2 rounded-md border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('component_type') border-red-500 @enderror">
                                <option value="">Select Component Type</option>
                                @foreach(['CPU', 'GPU', 'RAM', 'Motherboard', 'Storage', 'PSU', 'Case', 'Cooling', 'Other'] as $type)
                                    <option value="{{ $type }}" {{ $tradeIn->component_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('component_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-5">
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">
                                Brand <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="brand" name="brand" value="{{ old('brand', $tradeIn->brand) }}" required
                                class="w-full px-3 py-2 rounded-md border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('brand') border-red-500 @enderror"
                                placeholder="e.g. ASUS, Nvidia, Intel">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-3">
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">
                                Condition <span class="text-red-500">*</span>
                            </label>
                            <select id="condition" name="condition" required
                                class="w-full px-3 py-2 rounded-md border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('condition') border-red-500 @enderror">
                                @foreach(['Like New', 'Used', 'Needs Repair'] as $condition)
                                    <option value="{{ $condition }}" {{ $tradeIn->condition == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                                @endforeach
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Second row -->
                        <div class="md:col-span-9">
                            <label for="component_details" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Details <span class="text-red-500">*</span>
                            </label>
                            <textarea id="component_details" name="component_details" rows="3" required
                                class="w-full rounded-md px-3 py-2 border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('component_details') border-red-500 @enderror"
                                placeholder="Describe your component including model number, specifications, and any relevant details about its condition...">{{ old('component_details', $tradeIn->component_details) }}</textarea>
                            @error('component_details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-3">
                            <label for="pricing" class="block text-sm font-medium text-gray-700 mb-1">
                                Price ($) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" min="0" id="pricing" name="pricing" value="{{ old('pricing', $tradeIn->pricing) }}" required
                                    class="pl-7 w-full px-3 py-2 rounded-md border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('pricing') border-red-500 @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('pricing')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Field (Only in Edit form) -->
                        <div class="md:col-span-12">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="w-full px-3 py-2 rounded-md border-gray-50 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror">
                                @foreach(['Available', 'Pending', 'Sold', 'Removed'] as $status)
                                    <option value="{{ $status }}" {{ $tradeIn->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image upload -->
                        <div class="md:col-span-12">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Image
                            </label>
                            
                            @if($tradeIn->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $tradeIn->image_path) }}" alt="Current image" class="h-32 rounded-md shadow border border-gray-200 object-cover">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row mt-1 p-4 border-2 border-gray-300 border-dashed rounded-md h-44">
                                <div class="w-full md:w-1/4 flex items-center justify-center mb-4 md:mb-0">
                                    <svg class="h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="w-full md:w-3/4 flex flex-col justify-center">
                                    <div class="flex text-sm text-gray-600 justify-center md:justify-start">
                                        <label for="image" class="relative cursor-pointer border-gray-50 bg-gray-50 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 text-center md:text-left mt-2">PNG, JPG, GIF up to 10MB</p>
                                    <p class="text-xs text-gray-500 text-center md:text-left">Leave empty to keep current image</p>
                                    
                                    <!-- Image preview placeholder - will be shown when image is selected -->
                                    <div id="preview-container" class="mt-3 hidden">
                                        <img id="image-preview" class="max-h-20 rounded-md mx-auto md:mx-0" src="" alt="Image preview">
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('trade-in.show', $tradeIn) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-800 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Listing
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.getElementById("image");
        const imagePreview = document.getElementById("image-preview");
        const previewContainer = document.getElementById("preview-container");
        
        // Handle file input changes
        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove("hidden");
                };
                
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = "";
                previewContainer.classList.add("hidden");
            }
        });
    });
</script>
@endsection