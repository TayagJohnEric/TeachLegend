@extends('layouts.customer.app')

@section('title', 'My PC Builds')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">My PC Builds</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($pcBuilds->isEmpty())
            <p class="text-gray-500">You haven't saved any PC builds yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pcBuilds as $pcBuild)
                    <div class="border rounded-lg p-4 shadow-md">
                        <h2 class="text-lg font-semibold text-gray-700">{{ $pcBuild->name }}</h2>
                        <p><strong>Budget:</strong> ${{ number_format($pcBuild->budget, 2) }}</p>
                        <p><strong>Total Cost:</strong> ${{ number_format($pcBuild->total_cost, 2) }}</p>
                        <p><strong>Created At:</strong> {{ $pcBuild->created_at->format('d M, Y') }}</p>

                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('pc-builder.show', $pcBuild->id) }}" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                View Details
                            </a>

                            <form action="{{ route('pc-builder.destroy', $pcBuild->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this build?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('pc-builder.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Create New Build
            </a>
        </div>
    </div>
</div>
@endsection
