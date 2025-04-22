@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Orders</h1>
        <div class="flex space-x-4">
            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600" onclick="window.location.href='{{ route('orders.create') }}'">
                New Order
            </button>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-gray-500 text-sm">Total Orders</h3>
            <p class="text-2xl font-bold">{{ $totalOrders }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-gray-500 text-sm">New Orders</h3>
            <p class="text-2xl font-bold">{{ $newOrders }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-gray-500 text-sm">Processing</h3>
            <p class="text-2xl font-bold">{{ $processingOrders }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-gray-500 text-sm">Completed</h3>
            <p class="text-2xl font-bold">{{ $completedOrders }}</p>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->customer_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->table_number }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @foreach($order->items as $item)
                                {{ $item->quantity }}x {{ $item->menuItem->name }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status === 'new') bg-blue-100 text-blue-800
                                @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1">
                                    <option value="new" {{ $order->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection 