@extends('layouts.customer.app')

@section('title', 'My PC Builds')

@section('content')
<div class="container mx-auto px-4 py-0">
    <div class=" rounded-lg p-6 md:p-8">
        <div class="flex justify-between items-start mb-9 flex-wrap gap-4">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Your Custom PC Builds</h1>
            </div>
            
            <a href="{{ route('pc-builder.index') }}" class="bg-gradient-to-r from-blue-600 to-indigo-800 text-sm font-medium text-white px-4 py-3 rounded-md hover:bg-indigo-700 transition duration-200 flex items-center h-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create New Build
            </a>
        </div>
        

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($pcBuilds->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 bg-[#F6F5FA] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-500 text-lg">You haven't saved any PC builds yet.</p>
                <p class="text-gray-400 mt-2">Create your first custom PC build to get started!</p>
            </div>
        @else
            <div class="grid grid-cols-1 mt-5 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pcBuilds as $pcBuild)
                    <div class=" bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-5">
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ $pcBuild->name }}</h2>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Budget:</span>
                                    <span class="font-bold text-blue-500">${{ number_format($pcBuild->budget, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Cost:</span>
                                    <span class="font-bold text-green-500">${{ number_format($pcBuild->total_cost, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Created:</span>
                                    <span class="font-bold text-gray-600">{{ $pcBuild->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="flex space-x-2 pt-3 border-t border-gray-100">
                                <a href="{{ route('pc-builder.show', $pcBuild->id) }}" class="flex-1 bg-indigo-50 text-indigo-700 px-3 py-2 rounded-md text-center hover:bg-indigo-100 transition duration-200">
                                    View Details
                                </a>

                                <form action="{{ route('pc-builder.destroy', $pcBuild->id) }}" method="POST" class="flex-none" onsubmit="return confirm('Are you sure you want to delete this build?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-50 text-gray-500 px-3 py-2 rounded-md hover:bg-gray-100 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection