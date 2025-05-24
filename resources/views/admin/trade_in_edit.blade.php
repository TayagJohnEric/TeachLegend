@extends('layouts.admin.app')
@section('title', 'Edit Trade-In Listing')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-6">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-2xl font-semibold mb-6">Edit Trade-In</h2>

        <form action="{{ route('admin.trade-ins.update', $trade_in) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 shadow rounded">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-semibold">User</label>
                <select name="user_id" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $trade_in->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold">Component Details</label>
                <textarea name="component_details" class="w-full border-gray-300 rounded" required>{{ old('component_details', $trade_in->component_details) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 font-semibold">Condition</label>
                    <select name="condition" class="w-full border-gray-300 rounded" required>
                        @foreach(['Like New', 'Used', 'Needs Repair'] as $option)
                            <option value="{{ $option }}" {{ old('condition', $trade_in->condition) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded" required>
                        @foreach(['Available', 'Pending', 'Sold', 'Removed'] as $option)
                            <option value="{{ $option }}" {{ old('status', $trade_in->status) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 font-semibold">Pricing ($)</label>
                    <input type="number" step="0.01" name="pricing" value="{{ old('pricing', $trade_in->pricing) }}" class="w-full border-gray-300 rounded" required>
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Views</label>
                    <input type="number" name="views" value="{{ old('views', $trade_in->views) }}" class="w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 font-semibold">Component Type</label>
                    <input type="text" name="component_type" value="{{ old('component_type', $trade_in->component_type) }}" class="w-full border-gray-300 rounded">
                </div>

                <div>
                    <label class="block mb-2 font-semibold">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $trade_in->brand) }}" class="w-full border-gray-300 rounded">
                </div>
            </div>

            <div>
                <label class="block mb-2 font-semibold">Image</label>
                <input type="file" name="image_path" class="w-full border-gray-300 rounded">

                @if($trade_in->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $trade_in->image_path) }}" alt="Component Image" class="w-32 border rounded shadow">
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
