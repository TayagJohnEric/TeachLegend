@extends('layouts.admin.app')
@section('title', 'Trade-In Details')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-6">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4">Trade-In Listing Details</h2>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="font-semibold">User:</span> {{ $trade_in->user->name }} ({{ $trade_in->user->email }})
                </div>

                <div>
                    <span class="font-semibold">Component Type:</span> {{ $trade_in->component_type ?? 'N/A' }}
                </div>

                <div>
                    <span class="font-semibold">Brand:</span> {{ $trade_in->brand ?? 'N/A' }}
                </div>

                <div>
                    <span class="font-semibold">Condition:</span> {{ $trade_in->condition }}
                </div>

                <div>
                    <span class="font-semibold">Status:</span> 
                    <span class="inline-block px-2 py-1 text-xs rounded 
                        @if($trade_in->status === 'Available') bg-green-100 text-green-800
                        @elseif($trade_in->status === 'Pending') bg-yellow-100 text-yellow-800
                        @elseif($trade_in->status === 'Sold') bg-blue-100 text-blue-800
                        @else bg-gray-200 text-gray-800
                        @endif">
                        {{ $trade_in->status }}
                    </span>
                </div>

                <div>
                    <span class="font-semibold">Pricing:</span> ${{ number_format($trade_in->pricing, 2) }}
                </div>

                <div>
                    <span class="font-semibold">Views:</span> {{ $trade_in->views }}
                </div>

                <div>
                    <span class="font-semibold">Component Details:</span>
                    <p class="mt-1 bg-gray-50 border rounded p-3">{{ $trade_in->component_details }}</p>
                </div>

                <div>
                    <span class="font-semibold">Created At:</span> {{ $trade_in->created_at->format('d M Y, h:i A') }}
                </div>

                <div>
                    <span class="font-semibold">Updated At:</span> {{ $trade_in->updated_at->format('d M Y, h:i A') }}
                </div>

                @if($trade_in->image_path)
                <div>
                    <span class="font-semibold block mb-2">Image:</span>
                    <img src="{{ asset('storage/' . $trade_in->image_path) }}" alt="Component Image" class="w-64 rounded border shadow">
                </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.trade-ins.edit', $trade_in) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                <a href="{{ route('admin.trade-ins.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
