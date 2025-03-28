@extends('layouts.customer.app')

@section('title', 'PC Build Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">PC Build Details</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Build Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Build Information</h2>
                <div class="mt-2 space-y-2">
                    <p><strong>User:</strong> {{ $pcBuild->user->name }}</p>
                    <p><strong>Budget:</strong> ${{ number_format($pcBuild->budget, 2) }}</p>
                    <p><strong>Total Cost:</strong> ${{ number_format($pcBuild->total_cost, 2) }}</p>
                    <p><strong>Created At:</strong> {{ $pcBuild->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            {{-- Selected Components --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Selected Components</h2>
                <div class="mt-2 space-y-2">
                    @if($selectedProducts->isEmpty())
                        <p class="text-gray-500">No components selected.</p>
                    @else
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach($selectedProducts as $product)
                                <li>
                                    <span class="font-semibold">{{ $product->name }}</span> - 
                                    ${{ number_format($product->price, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('pc-builder.list') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to List
            </a>

            <form action="{{ route('pc-builder.destroy', $pcBuild->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this build?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Delete Build
                </button>
            </form>

            <a href="{{ route('customer.checkout', ['pc_build_id' => $pcBuild->id]) }}" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Proceed to Checkout
             </a>
        </div>
    </div>
</div>

@endsection