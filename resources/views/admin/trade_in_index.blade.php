@extends('layouts.admin.app')
@section('title', 'Trade-in Management')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-6">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Trade-In Listings</h2>
            {{-- "Add New" button removed --}}
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <th class="py-2 px-4">Component</th>
                    <th class="py-2 px-4">User</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Pricing</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listings as $listing)
                    <tr class="border-t hover:bg-gray-50 text-sm">
                        <td class="py-2 px-4">{{ $listing->component_type }} - {{ $listing->brand }}</td>
                        <td class="py-2 px-4">{{ $listing->user->name }}</td>
                        <td class="py-2 px-4">{{ $listing->status }}</td>
                        <td class="py-2 px-4">${{ number_format($listing->pricing, 2) }}</td>
                        <td class="py-2 px-4 flex flex-wrap gap-3 items-center">
                            <a href="{{ route('admin.trade-ins.show', $listing) }}" class="text-gray-700 hover:text-black">Show</a>
                            <a href="{{ route('admin.trade-ins.edit', $listing) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.trade-ins.destroy', $listing) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this listing?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $listings->links() }}
        </div>
    </div>
</div>
@endsection
