<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archived Orders - Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8fafc;
    }

    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
    }

    .card {
      transition: all 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  @extends('layouts.app')

  @section('content')
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Archived Orders</h1>
      <a href="{{ route('orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
        <i class="fas fa-arrow-left mr-2"></i> Back to Orders
      </a>
    </div>

    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed At</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orders as $order)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->customer_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->table_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                  <ul class="list-disc list-inside">
                    @foreach($order->items as $item)
                      <li>{{ $item->menu->name }} ({{ $item->quantity }}x)</li>
                    @endforeach
                  </ul>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ $order->updated_at->format('d M Y H:i') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                  No completed orders found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-4">
      {{ $orders->links() }}
    </div>
  </div>
  @endsection

  <!-- JS Section -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const archiveList = document.getElementById("archiveList");
      const searchInput = document.getElementById("searchInput");
  
      const archivedOrders = [
        { orderId: 1, customer: 'John Doe', items: ['Burger', 'Fries'], totalPrice: 12.99, status: 'Archived' },
        { orderId: 2, customer: 'Jane Smith', items: ['Pizza', 'Soda'], totalPrice: 15.99, status: 'Archived' },
        { orderId: 3, customer: 'Alice Johnson', items: ['Burger', 'Coke'], totalPrice: 10.99, status: 'Archived' }
      ];
  
      function renderArchive(orders = archivedOrders) {
        archiveList.innerHTML = "";
        orders.forEach((order) => {
          archiveList.innerHTML += `
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-all card-hover">
              <h2 class="text-xl font-semibold text-gray-800 mb-2">Order #${order.orderId}</h2>
              <p class="text-gray-600"><strong>Customer:</strong> ${order.customer}</p>
              <p class="text-gray-600"><strong>Items:</strong> ${order.items.join(', ')}</p>
              <p class="text-gray-600"><strong>Total:</strong> $${order.totalPrice}</p>
              <p class="text-gray-500 text-sm mt-1"><strong>Status:</strong> ${order.status}</p>
            </div>
          `;
        });
      }
  
      function searchOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const filtered = archivedOrders.filter(order =>
          order.customer.toLowerCase().includes(searchTerm) ||
          order.items.join(', ').toLowerCase().includes(searchTerm)
        );
        renderArchive(filtered);
      }
  
      searchInput.addEventListener("input", searchOrders);
      renderArchive();
    });
  </script>
  
</body>
</html>