@extends('layouts.customer.app')

@section('title', 'Create Trade-in Listing')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create Trade-In Listing</h1>
        <p class="mt-2 text-gray-600">List your component for sale on our marketplace</p>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Component Information
                </h2>
            </div>
            
            <div class="p-6">
                <form method="POST" action="{{ route('trade-in.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Component Type -->
                        <div class="md:col-span-3">
                            <label for="component_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Type <span class="text-red-500">*</span>
                            </label>
                            <select id="component_type" name="component_type" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('component_type') border-red-500 @enderror">
                                <option value="">Select Component Type</option>
                                <option value="CPU">CPU</option>
                                <option value="GPU">GPU</option>
                                <option value="RAM">RAM</option>
                                <option value="Motherboard">Motherboard</option>
                                <option value="Storage">Storage</option>
                                <option value="PSU">Power Supply</option>
                                <option value="Case">Case</option>
                                <option value="Cooling">Cooling</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('component_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div class="md:col-span-2">
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">
                                Brand <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="brand" name="brand" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('brand') border-red-500 @enderror"
                                placeholder="e.g. ASUS, Nvidia, Intel">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Condition -->
                        <div class="md:col-span-1">
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">
                                Condition <span class="text-red-500">*</span>
                            </label>
                            <select id="condition" name="condition" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('condition') border-red-500 @enderror">
                                <option value="Like New">Like New</option>
                                <option value="Used">Used</option>
                                <option value="Needs Repair">Needs Repair</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Component Details -->
                        <div class="md:col-span-3">
                            <label for="component_details" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Details <span class="text-red-500">*</span>
                            </label>
                            <textarea id="component_details" name="component_details" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('component_details') border-red-500 @enderror"
                                placeholder="Describe your component including model number, specifications, and any relevant details about its condition..."></textarea>
                            @error('component_details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="md:col-span-1">
                            <label for="pricing" class="block text-sm font-medium text-gray-700 mb-1">
                                Price ($) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" min="0" id="pricing" name="pricing" required
                                    class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('pricing') border-red-500 @enderror"
                                    placeholder="0.00">
                            </div>
                            @error('pricing')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Component Image -->
                        <div class="md:col-span-3">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                Component Image
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Clear images help your listing sell faster.</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('trade-in.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Listing
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection