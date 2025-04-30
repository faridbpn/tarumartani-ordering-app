<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Archive - FoodExpress Admin</title>
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
        
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal-content {
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
        
        .tab-active {
            border-bottom: 3px solid #3b82f6;
            color: #3b82f6;
            font-weight: 600;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 0.5rem;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f1f5f9;
        }
        
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .collapsible-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .collapsible.active .collapsible-content {
            max-height: 1000px;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
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
        <header class="bg-white shadow-sm p-4 flex items-center justify-between sticky-header">
            <div class="flex items-center space-x-4">
                <button class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-800">Order Archive</h2>
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
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <!-- Tabs -->
            <div class="bg-white border-b border-gray-200 px-4">
                <div class="flex space-x-8">
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm tab-active" data-tab="all">
                        All Orders
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="completed">
                        Completed
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="canceled">
                        Canceled
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="failed">
                        Failed
                    </button>
                </div>
            </div>
            
            <!-- Filters and Actions -->
            <div class="bg-white rounded-xl shadow p-4 m-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="relative w-64">
                        <input type="text" placeholder="Search orders..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <div class="relative">
                        <button class="flex items-center space-x-2 px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-filter text-gray-500"></i>
                            <span>Filters</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <div class="dropdown-content mt-1 p-3 w-64">
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option>All Time</option>
                                    <option>Today</option>
                                    <option>Last 7 Days</option>
                                    <option>Last 30 Days</option>
                                    <option>Custom Range</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Value</label>
                                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option>Any Amount</option>
                                    <option>Under $20</option>
                                    <option>$20 - $50</option>
                                    <option>$50 - $100</option>
                                    <option>Over $100</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option>All Methods</option>
                                    <option>Credit Card</option>
                                    <option>PayPal</option>
                                    <option>Cash on Delivery</option>
                                </select>
                            </div>
                            <div class="flex justify-between mt-3">
                                <button class="text-sm text-gray-600 hover:text-gray-800">Reset</button>
                                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <button class="flex items-center space-x-2 px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-sort text-gray-500"></i>
                            <span>Sort By</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <div class="dropdown-content mt-1 p-2 w-48">
                            <div class="dropdown-item text-sm">Newest First</div>
                            <div class="dropdown-item text-sm">Oldest First</div>
                            <div class="dropdown-item text-sm">Highest Amount</div>
                            <div class="dropdown-item text-sm">Lowest Amount</div>
                        </div>
                    </div>
                    
                    <button class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90">
                        <i class="fas fa-file-export mr-2"></i> Export
                    </button>
                </div>
            </div>
            
            <!-- Grouped Orders -->
            <div class="m-4">
                @foreach($archivedOrders->groupBy(function($order) {
                    return $order->archived_at->format('F Y');
                }) as $month => $orders)
                <div class="mb-6 bg-white rounded-xl shadow overflow-hidden">
                    <div class="collapsible active">
                        <button class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100">
                            <div class="flex items-center">
                                <h3 class="font-bold text-lg">{{ $month }}</h3>
                                <span class="ml-3 text-sm bg-gray-200 text-gray-700 px-2 py-1 rounded-full">{{ $orders->count() }} orders</span>
                            </div>
                            <i class="fas fa-chevron-down transition-transform duration-300 transform"></i>
                        </button>
                        
                        <div class="collapsible-content">
                            @foreach($orders as $order)
                            <div class="order-card border-b border-gray-200 last:border-b-0">
                                <div class="p-4 flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-blue-100 p-3 rounded-lg">
                                            <i class="fas fa-shopping-cart text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold">Order #{{ $order->id }}</h3>
                                            <p class="text-sm text-gray-500">{{ $order->archived_at->format('d M Y • h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <p class="font-bold">${{ number_format($order->total_amount, 2) }}</p>
                                            <span class="status-badge {{ $order->archive_status === 'completed' ? 'bg-green-100 text-green-800' : ($order->archive_status === 'canceled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($order->archive_status) }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="showOrderDetails({{ $order->id }})" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form action="{{ route('orders.restore', $order) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-2 bg-green-500 text-white rounded hover:bg-green-600">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this order?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="px-4 pb-4 -mt-2">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span class="mr-4">Customer: <span class="font-medium">{{ $order->user->name }}</span></span>
                                        <span class="mr-4">Items: <span class="font-medium">{{ $order->items->count() }}</span></span>
                                        <span>Payment: <span class="font-medium">Credit Card</span></span>
                                    </div>
                                    @if($order->archive_reason)
                                    <div class="mt-1 text-sm text-gray-600">
                                        <span>Reason: <span class="font-medium">{{ $order->archive_reason }}</span></span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="m-4 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-medium">{{ $archivedOrders->firstItem() }}</span> to <span class="font-medium">{{ $archivedOrders->lastItem() }}</span> of <span class="font-medium">{{ $archivedOrders->total() }}</span> orders
                </div>
                <nav class="inline-flex rounded-md shadow">
                    @if($archivedOrders->onFirstPage())
                    <span class="px-3 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-gray-400">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    @else
                    <a href="{{ $archivedOrders->previousPageUrl() }}" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    @endif

                    @foreach(range(1, $archivedOrders->lastPage()) as $page)
                    <a href="{{ $archivedOrders->url($page) }}" class="px-4 py-2 border-t border-b border-gray-300 bg-white {{ $archivedOrders->currentPage() === $page ? 'text-blue-600 font-medium' : 'text-gray-500 hover:bg-gray-50' }}">
                        {{ $page }}
                    </a>
                    @endforeach

                    @if($archivedOrders->hasMorePages())
                    <a href="{{ $archivedOrders->nextPageUrl() }}" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    @else
                    <span class="px-3 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-gray-400">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    @endif
                </nav>
            </div>
        </main>
    </div>

    <!-- Modal for Order Details -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Order Details</h3>
                <button onclick="closeOrderDetails()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="orderDetailsContent">
                <!-- Order details will be loaded here -->
            </div>
        </div>
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

            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('tab-active');
                        btn.classList.add('text-gray-500');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('tab-active');
                    this.classList.remove('text-gray-500');
                    
                    // Filter orders based on the tab
                    const tab = this.getAttribute('data-tab');
                    const orders = document.querySelectorAll('.order-card');
                    
                    orders.forEach(order => {
                        const status = order.querySelector('.status-badge').textContent.toLowerCase();
                        if (tab === 'all' || status === tab) {
                            order.style.display = 'block';
                        } else {
                            order.style.display = 'none';
                        }
                    });
                });
            });
            
            // Collapsible sections
            const collapsibles = document.querySelectorAll('.collapsible');
            
            collapsibles.forEach(collapsible => {
                const button = collapsible.querySelector('button');
                
                button.addEventListener('click', function() {
                    collapsible.classList.toggle('active');
                    
                    const icon = this.querySelector('i');
                    if (collapsible.classList.contains('active')) {
                        icon.classList.add('rotate-180');
                    } else {
                        icon.classList.remove('rotate-180');
                    }
                });
            });
            
            // Modal elements
            const orderDetailsModal = document.getElementById('orderDetailsModal');
            const orderDetailsContent = document.getElementById('orderDetailsContent');
            
            // Toggle modal function
            function toggleModal(modal, show) {
                if (show) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }
            
            // Show order details
            function showOrderDetails(orderId) {
                fetch(`/orders/${orderId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        let html = `
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold">Order ID: ${data.id}</h4>
                                    <p>Customer: ${data.customer_name}</p>
                                    <p>Table: ${data.table_number}</p>
                                    <p>Status: ${data.status}</p>
                                    <p>Date: ${new Date(data.created_at).toLocaleString()}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Order Items:</h4>
                                    <ul class="list-disc pl-4">
                                        ${data.items.map(item => `
                                            <li>${item.menu_item.name} x ${item.quantity} - Rp ${item.subtotal.toLocaleString()}</li>
                                        `).join('')}
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Total Amount: Rp ${data.total_amount.toLocaleString()}</h4>
                                </div>
                            </div>
                        `;
                        
                        orderDetailsContent.innerHTML = html;
                        toggleModal(orderDetailsModal, true);
                    });
            }
            
            // Close order details
            function closeOrderDetails() {
                toggleModal(orderDetailsModal, false);
            }
        });
    </script>
</body>
</html>