@extends('layouts.customer.app')
@section('title', 'Edit Trade-In Listing')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Edit Trade-In Listing</h2>
        </div>
        <div class="px-6 py-6">
            <form method="POST" action="{{ route('trade-in.update', $tradeIn) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Component Type -->
                <div>
                    <label for="component_type" class="block text-sm font-medium text-gray-700">Component Type</label>
                    <select id="component_type" name="component_type" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('component_type') border-red-500 @enderror">
                        <option value="">Select Component Type</option>
                        @foreach(['CPU', 'GPU', 'RAM', 'Motherboard', 'Storage', 'PSU', 'Case', 'Cooling', 'Other'] as $type)
                            <option value="{{ $type }}" {{ $tradeIn->component_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('component_type')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                    <input id="brand" type="text" name="brand" value="{{ old('brand', $tradeIn->brand) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('brand') border-red-500 @enderror">
                    @error('brand')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Component Details -->
                <div>
                    <label for="component_details" class="block text-sm font-medium text-gray-700">Component Details</label>
                    <textarea id="component_details" name="component_details" rows="4" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('component_details') border-red-500 @enderror">{{ old('component_details', $tradeIn->component_details) }}</textarea>
                    @error('component_details')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700">Condition</label>
                    <select id="condition" name="condition" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('condition') border-red-500 @enderror">
                        @foreach(['Like New', 'Used', 'Needs Repair'] as $condition)
                            <option value="{{ $condition }}" {{ $tradeIn->condition == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                        @endforeach
                    </select>
                    @error('condition')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pricing -->
                <div>
                    <label for="pricing" class="block text-sm font-medium text-gray-700">Price ($)</label>
                    <input id="pricing" type="number" step="0.01" name="pricing" value="{{ old('pricing', $tradeIn->pricing) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('pricing') border-red-500 @enderror">
                    @error('pricing')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                        @foreach(['Available', 'Pending', 'Sold', 'Removed'] as $status)
                            <option value="{{ $status }}" {{ $tradeIn->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Component Image</label>
                    @if($tradeIn->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $tradeIn->image_path) }}" alt="Current image" class="h-32 rounded-md shadow border border-gray-200 object-cover">
                            <p class="text-sm text-gray-500 mt-1">Current image</p>
                        </div>
                    @endif
                    <input id="image" type="file" name="image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                    <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image</p>
                    @error('image')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update Listing
                    </button>
                    <a href="{{ route('trade-in.show', $tradeIn) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
