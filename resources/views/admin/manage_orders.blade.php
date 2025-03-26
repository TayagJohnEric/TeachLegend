@extends('layouts.admin.app')

@section('title', 'Admin Manage Orders')

@section('content')

<div class="container mx-auto px-4 py-6 max-w-[112rem]">
    <!-- Filter Section -->
    <div class="mb-4 bg-white rounded-lg shadow-md shadow-gray-200 p-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <label for="order_status" class="text-sm font-medium text-gray-700 whitespace-nowrap">
                    Filter by Status:
                </label>
                <select 
                    name="order_status" 
                    id="order_status" 
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300" 
                    onchange="this.form.submit()"
                >
                    <option value="">All Orders</option>
                    <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>
                        Processing
                    </option>
                    <option value="completed" {{ request('order_status') == 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                    <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled
                    </option>
                </select>
            </div>
        </form>
    </div>

    <!-- Order List -->
    <div class="mt-4 bg-white rounded-lg shadow-md shadow-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Order List</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex flex-col space-y-2">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center space-x-2">
                                        @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded-md">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No Image</span>
                                            </div>
                                        @endif
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex flex-col space-y-2">
                                @foreach($order->orderItems as $item)
                                    <span>x{{ $item->quantity }}</span>
                                @endforeach
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $order->user->first_name }} {{ $order->user->last_name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($order->order_status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->order_status == 'processing') bg-blue-100 text-blue-800
                                @elseif($order->order_status == 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                                @csrf
                                <select name="order_status" onchange="this.form.submit()" class="text-sm px-2 py-1 border rounded-md">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
