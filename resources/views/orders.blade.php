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
    <div class="sidebar gradient-bg text-white w-64 flex-shrink-0 hidden md:flex flex-col">
        <div class="p-4 flex items-center space-x-2">
            <i class="fas fa-utensils text-2xl"></i>
            <h1 class="text-xl font-bold">FoodExpress</h1>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <nav class="px-4 py-6 space-y-1">
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-utensils"></i>
                    <span>Menu Items</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg active-nav">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>
        
        <div class="p-4 border-t border-white border-opacity-20">
            <div class="flex items-center space-x-3">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-medium">Admin User</p>
                    <p class="text-xs opacity-80">admin@foodexpress.com</p>
                </div>
            </div>
            <button class="w-full mt-4 py-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </div>
    </div>
    
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
                        <input type="text" id="searchInput" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="statusFilter" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="All">All Status</option>
                        <option value="Completed">Completed</option>
                        <option value="Processing">Processing</option>
                        <option value="On Delivery">On Delivery</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Pending">Pending</option>
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
            @if ($orders->isEmpty())
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800">No Orders Found</h3>
                    <p class="text-gray-500">There are currently no orders to display.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($orders as $order)
                        <div class="order-card bg-white rounded-xl shadow overflow-hidden" 
                             data-status="{{ $order->status }}"
                             data-search="{{ strtolower($order->id . ' ' . $order->customer_name . ' ' . implode(' ', array_column($order->items->toArray(), 'name'))) }}">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <span class="font-medium">#{{ $order->id }}</span>
                                <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center mb-3">
                                    <img src="https://randomuser.me/api/portraits/{{ rand(0,1) ? 'men' : 'women' }}/{{ rand(1,99) }}.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-medium">{{ $order->customer_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->items->count() }} items • ${{ number_format($order->total, 2) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Order Items -->
                                <div class="mb-3">
                                    @foreach ($order->items as $item)
                                        <div class="order-item flex justify-between">
                                            <span>{{ $item->name }}</span>
                                            <span class="font-medium">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Total and Status -->
                                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                    <div>
                                        <p class="text-sm text-gray-500">Total</p>
                                        <p class="font-bold">${{ number_format($order->total, 2) }}</p>
                                    </div>
                                    <span class="status-badge {{ $order->status == 'Completed' ? 'bg-green-100 text-green-800' : ($order->status == 'Processing' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'On Delivery' ? 'bg-blue-100 text-blue-800' : ($order->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-purple-100 text-purple-800'))) }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-0');
                sidebar.classList.toggle('z-40');
            });

            // Status filter and search
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            const orderCards = document.querySelectorAll('.order-card');
            const noOrdersMessage = document.querySelector('.no-orders-message');

            function filterCards() {
                const selectedStatus = statusFilter.value;
                const searchTerm = searchInput.value.toLowerCase();
                let visibleCards = 0;

                orderCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    const cardSearchData = card.getAttribute('data-search');

                    const statusMatch = selectedStatus === 'All' || cardStatus === selectedStatus;
                    const searchMatch = !searchTerm || cardSearchData.includes(searchTerm);

                    if (statusMatch && searchMatch) {
                        card.style.display = 'block';
                        visibleCards++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show "No orders found" message if no cards are visible
                if (noOrdersMessage) {
                    noOrdersMessage.style.display = visibleCards === 0 && orderCards.length > 0 ? 'block' : 'none';
                }
            }

            statusFilter.addEventListener('change', filterCards);
            searchInput.addEventListener('input', filterCards);
        });
    </script>
    
</body>
</html>