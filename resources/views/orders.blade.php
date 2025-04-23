<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - FoodExpress Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }
        
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .active-nav {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }
        
        .order-card {
            transition: all 0.2s ease;
        }
        
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }
        
        .order-item {
            border-bottom: 1px dashed #e5e7eb;
            padding: 0.5rem 0;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('layouts.app')
    
    <!-- Mobile sidebar toggle -->
    <div class="md:hidden fixed bottom-4 right-4 z-50">
        <button id="sidebar-toggle" class="gradient-bg text-white p-3 rounded-full shadow-lg">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white shadow-sm p-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-800">Orders Management</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-xl text-gray-500"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                </div>
                <div class="hidden md:flex items-center space-x-2">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="w-8 h-8 rounded-full">
                    <span class="font-medium">Admin</span>
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
            <!-- Filters and Actions -->
            <div class="bg-white rounded-xl shadow p-4 mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Processing</option>
                        <option>On Delivery</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <button class="px-4 py-2 gradient-bg text-white hover:opacity-90 rounded-lg transition-all">
                        <i class="fas fa-plus mr-2"></i> New Order
                    </button>
                </div>
            </div>
            
            <!-- Order Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($orders as $order)
                    <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <span class="font-medium">#ORD-{{ $order->id }}</span>
                            <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center mb-3">
                                <img src="https://randomuser.me/api/portraits/men/{{ $order->id % 100 }}.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->items->count() }} items • Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                </div>
                            </div>
            
                            <!-- Order Items -->
                            <div class="mb-3">
                                @foreach($order->items as $item)
                                    <div class="order-item flex justify-between">
                                        <span>{{ $item->menuItem->name }}</span>
                                        <span class="font-medium">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
            
                            <!-- Total and Status -->
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-500">Total</p>
                                    <p class="font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                </div>
                                <span class="status-badge {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : ($order->status == 'processing' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'on_delivery' ? 'bg-blue-100 text-blue-800' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-purple-100 text-purple-800'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        <p>Belum ada pesanan.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-blue-600 font-medium">1</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">3</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">4</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">5</a>
                    <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </main>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable Pusher logging - optional for debugging
    Pusher.logToConsole = true;

    // Setup Pusher
    const pusher = new Pusher('your-pusher-key', {
        cluster: 'your-pusher-cluster'
    });

    // Subscribe ke channel 'orders'
    const channel = pusher.subscribe('orders');

    // Listen untuk event 'App\\Events\\OrderPlaced'
    channel.bind('App\\Events\\OrderPlaced', function(data) {
        // Tambahkan pesanan baru ke grid
        const orderGrid = document.querySelector('.grid');
        const orderCard = `
            <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <span class="font-medium">#ORD-${data.id}</span>
                    <span class="text-xs text-gray-500">${data.created_at}</span>
                </div>
                <div class="p-4">
                    <div class="flex items-center mb-3">
                        <img src="https://randomuser.me/api/portraits/men/${data.id % 100}.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">${data.customer_name}</p>
                            <p class="text-xs text-gray-500">${data.items.length} items • Rp ${data.total.toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        ${data.items.map(item => `
                            <div class="order-item flex justify-between">
                                <span>${item.name}</span>
                                <span class="font-medium">${item.quantity} × Rp ${item.price.toLocaleString()}</span>
                            </div>
                        `).join('')}
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="font-bold">Rp ${data.total.toLocaleString()}</p>
                        </div>
                        <span class="status-badge bg-purple-100 text-purple-800">${data.status}</span>
                    </div>
                </div>
            </div>
        `;
        orderGrid.insertAdjacentHTML('afterbegin', orderCard);
    });
</script>
</body>
</html>