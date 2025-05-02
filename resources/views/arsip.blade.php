<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Archive - FoodExpress Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Modal Animation for Delete Confirmation */
        #deleteConfirmationModal .transform {
            transition: transform 0.3s ease;
        }

        #deleteConfirmationModal.active {
            display: flex;
        }

        #deleteConfirmationModal.active .transform {
            transform: scale(1);
        }

        /* Modal Styling */
        #deleteConfirmationModal .bg-white {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Icon Animation */
        #deleteConfirmationModal .bg-red-100 {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Button Hover Effects */
        #deleteConfirmationModal button {
            transition: background-color 0.3s ease;
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
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg" role="tablist">
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ !request()->get('tab') || request()->get('tab') === 'all' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="all">
                        All
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('tab') === 'pending' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="pending">
                        Pending
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('tab') === 'processing' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="processing">
                        Processing
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('tab') === 'on delivery' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="on delivery">
                        On Delivery
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('tab') === 'completed' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="completed">
                        Completed
                    </button>
                    <button class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('tab') === 'cancelled' ? 'bg-white text-gray-900' : 'text-gray-500 hover:text-gray-700' }}"
                            role="tab" data-tab="cancelled">
                        Cancelled
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
                        <button id="filterButton" class="flex items-center space-x-2 px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-filter text-gray-500"></i>
                            <span>Filters</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <div id="filterDropdown" class="hidden absolute right-0 mt-1 p-3 w-64 bg-white rounded-lg shadow-lg z-50">
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm date-range">
                                    <option value="">All Time</option>
                                    <option value="today">Today</option>
                                    <option value="last7days">Last 7 Days</option>
                                    <option value="last30days">Last 30 Days</option>
                                </select>
                            </div>
                            <div class="flex justify-between mt-3">
                                <button id="resetFilters" class="text-sm text-gray-600 hover:text-gray-800">Reset</button>
                                <button id="applyFilters" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <button id="sortButton" class="flex items-center space-x-2 px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-sort text-gray-500"></i>
                            <span>Sort By</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        <div id="sortDropdown" class="hidden absolute right-0 mt-1 p-2 w-48 bg-white rounded-lg shadow-lg z-50">
                            <button class="sort-option w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded" data-sort="newest">Newest First</button>
                            <button class="sort-option w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded" data-sort="oldest">Oldest First</button>
                            <button class="sort-option w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded" data-sort="highest">Highest Amount</button>
                            <button class="sort-option w-full text-left px-3 py-2 text-sm hover:bg-gray-50 rounded" data-sort="lowest">Lowest Amount</button>
                        </div>
                    </div>
                    
                    <a href="{{ route('arsip.export', request()->query()) }}" class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90">
                        <i class="fas fa-file-export mr-2"></i> Export PDF
                    </a>
                </div>
            </div>
            
            <!-- Grouped Orders -->
            <div class="m-4">
                @if($archivedOrders->isEmpty())
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <div class="mb-4">
                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Orders Found</h3>
                    <p class="text-gray-500">
                        @if(request()->get('tab') && request()->get('tab') !== 'all')
                            No {{ request()->get('tab') }} orders found.
                        @elseif(request()->get('date_range'))
                            No orders found for the selected date range.
                        @elseif(request()->get('search'))
                            No orders match your search "{{ request()->get('search') }}".
                        @else
                            There are no archived orders yet.
                        @endif
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('arsip.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-arrow-left mr-1"></i> Clear all filters
                        </a>
                    </div>
                </div>
                @else
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
                            <div class="order-card border-b border-gray-200 last:border-b-0" data-order-id="{{ $order->id }}">
                                <div class="p-4 flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-blue-100 p-3 rounded-lg">
                                            <i class="fas fa-shopping-cart text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold">Order #{{ $order->id }}</h3>
                                            <p class="text-sm text-gray-500" data-date="{{ $order->archived_at->format('d M Y • h:i A') }}">{{ $order->archived_at->format('d M Y • h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <p class="font-bold">Rp {{ number_format($order->total_amount, 2) }}</p>
                                            <span class="status-badge {{ $order->archive_status === 'completed' ? 'bg-green-100 text-green-800' : ($order->archive_status === 'canceled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}" data-status="{{ ucfirst($order->archive_status) }}">
                                                {{ ucfirst($order->archive_status) }}
                                            </span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="showOrderDetails({{ $order->id }})" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form action="{{ route('orders.restore', $order) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" class="btn-restore p-2 bg-green-500 text-white rounded hover:bg-green-600">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="showDeleteConfirmation({{ $order->id }}, this.form)" class="p-2 bg-red-500 text-white rounded hover:bg-red-600">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="px-4 pb-4 -mt-2">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span class="mr-4" data-customer-name="{{ $order->customer_name ?? '-' }}">Customer: <span class="font-medium">{{ $order->customer_name ?? '-' }}</span></span>
                                        <span class="mr-4" data-table-number="{{ $order->table_number }}">Table: <span class="font-medium">{{ $order->table_number }}</span></span>
                                        <span>Payment: <span class="font-medium">Credit Card</span></span>
                                    </div>
                                    @if($order->archive_reason)
                                    <div class="mt-1 text-sm text-gray-600">
                                        <span>Reason: <span class="font-medium">{{ $order->archive_reason }}</span></span>
                                    </div>
                                    @endif
                                    <div class="mt-2 hidden" data-order-items>
                                        @foreach($order->items as $item)
                                        <div data-order-item>
                                            <span data-item-name>{{ $item->menuItem->name ?? 'Unknown Item' }}</span>
                                            <span data-item-quantity>{{ $item->quantity }}</span>
                                            <span data-item-price>Rp {{ number_format($item->subtotal, 2) }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="hidden" data-total-amount>Rp {{ number_format($order->total_amount, 2) }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            
            <!-- Pagination -->
            @if(!$archivedOrders->isEmpty())
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
            @endif
        </main>
    </div>

    <!-- Modal for Order Details -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">📦 Order Details</h3>
                <button onclick="closeOrderDetails()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="orderDetailsContent">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 text-center transform scale-95 transition-transform duration-300">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah Anda yakin ingin menghapus order ini?</h3>
            <p class="text-sm text-gray-600 mb-4" id="deleteOrderId"></p>
            <div class="flex justify-center space-x-3">
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Hapus</button>
                <button onclick="closeDeleteConfirmation()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
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
            
            // Date range filter functionality
            const filterButton = document.getElementById('filterButton');
            const filterDropdown = document.getElementById('filterDropdown');
            const dateRangeSelect = document.querySelector('.date-range');
            const applyFilters = document.getElementById('applyFilters');
            const resetFilters = document.getElementById('resetFilters');

            if (filterButton && filterDropdown) {
                filterButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    filterDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!filterDropdown.contains(e.target) && !filterButton.contains(e.target)) {
                        filterDropdown.classList.add('hidden');
                    }
                });
            }

            if (dateRangeSelect && applyFilters) {
                applyFilters.addEventListener('click', function() {
                    const url = new URL(window.location.href);
                    if (dateRangeSelect.value) {
                        url.searchParams.set('date_range', dateRangeSelect.value);
                    } else {
                        url.searchParams.delete('date_range');
                    }
                    window.location.href = url.toString();
                });
            }

            if (resetFilters) {
                resetFilters.addEventListener('click', function() {
                    window.location.href = "{{ route('arsip.index') }}";
                });
            }

            // Tab switching functionality
            const tabs = document.querySelectorAll('[role="tab"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', tabId);
                    window.location.href = url.toString();
                });
            });

            // Sort functionality
            const sortButton = document.getElementById('sortButton');
            const sortDropdown = document.getElementById('sortDropdown');
            const sortOptions = document.querySelectorAll('.sort-option');

            if (sortButton && sortDropdown) {
                sortButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sortDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sortDropdown.contains(e.target) && !sortButton.contains(e.target)) {
                        sortDropdown.classList.add('hidden');
                    }
                });
            }

            if (sortOptions) {
                sortOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const url = new URL(window.location.href);
                        url.searchParams.set('sort', this.getAttribute('data-sort'));
                        window.location.href = url.toString();
                    });
                });
            }

            // Modal elements for order details
            const orderDetailsModal = document.getElementById('orderDetailsModal');
            const orderDetailsContent = document.getElementById('orderDetailsContent');
            
            function toggleModal(modal, show) {
                if (show) {
                    modal.classList.remove('hidden');
                    modal.classList.add('active');
                } else {
                    modal.classList.remove('active');
                    modal.classList.add('hidden');
                }
            }
            
            window.showOrderDetails = function(orderId) {
                // Get the order data from the DOM instead of making an API call
                const orderCard = document.querySelector(`[data-order-id="${orderId}"]`);
                if (!orderCard) return;

                const customerName = orderCard.querySelector('[data-customer-name]')?.textContent || 'Unknown';
                const tableNumber = orderCard.querySelector('[data-table-number]')?.textContent || 'N/A';
                const status = orderCard.querySelector('[data-status]')?.textContent || 'Unknown';
                const date = orderCard.querySelector('[data-date]')?.textContent || 'N/A';
                
                // Get order items
                const orderItems = [];
                const itemElements = orderCard.querySelectorAll('[data-order-item]');
                itemElements.forEach(item => {
                    const name = item.querySelector('[data-item-name]')?.textContent || 'Unknown Item';
                    const quantity = item.querySelector('[data-item-quantity]')?.textContent || '0';
                    const price = item.querySelector('[data-item-price]')?.textContent || 'Rp 0';
                    orderItems.push({ name, quantity, price });
                });

                const totalAmount = orderCard.querySelector('[data-total-amount]')?.textContent || 'Rp 0';

                let html = `
                    <div class="bg-white rounded-2xl shadow-xl p-6 space-y-6 text-gray-800 max-w-md mx-auto">
                        <div class="border-b pb-4">
                        </div>
                        <div class="space-y-2">
                        <p><span class="font-semibold text-gray-600">Order ID:</span> <span class="text-gray-900">${orderId}</span></p>
                        <p><span class="font-semibold text-gray-600">Customer:</span> <span class="text-gray-900">${customerName}</span></p>
                        <p><span class="font-semibold text-gray-600">Table:</span> <span class="text-gray-900">${tableNumber}</span></p>
                        <p><span class="font-semibold text-gray-600">Status:</span> 
                            <span class="inline-block px-2 py-1 text-sm font-medium rounded 
                            ${status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                status === 'Completed' ? 'bg-green-100 text-green-800' : 
                                'bg-gray-100 text-gray-800'}">
                            ${status}
                            </span>
                        </p>
                        <p><span class="font-semibold text-gray-600">Date:</span> <span class="text-gray-900">${date}</span></p>
                        </div>
                        <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">🧾 Order Items</h4>
                        <ul class="space-y-2">
                            ${orderItems.map(item => `
                            <li class="flex justify-between border rounded-lg px-3 py-2 bg-gray-50">
                                <div>
                                <p class="font-medium text-gray-700">${item.name}</p>
                                <p class="text-sm text-gray-500">x${item.quantity}</p>
                                </div>
                                <div class="text-right font-semibold text-gray-700">Rp ${item.price.toLocaleString('id-ID')}</div>
                            </li>
                            `).join('')}
                        </ul>
                        </div>
                        <div class="border-t pt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-800">Total:</span>
                        <span class="text-xl font-bold text-green-600">Rp ${totalAmount.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                `;

                orderDetailsContent.innerHTML = html;
                toggleModal(orderDetailsModal, true);
            }
            
            window.closeOrderDetails = function() {
                toggleModal(orderDetailsModal, false);
            }

            // Delete Confirmation Modal
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const deleteOrderIdText = document.getElementById('deleteOrderId');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            let deleteForm = null;

            window.showDeleteConfirmation = function(orderId, form) {
                deleteOrderIdText.textContent = `Order #${orderId}`;
                deleteForm = form;
                toggleModal(deleteConfirmationModal, true);
            }

            window.closeDeleteConfirmation = function() {
                toggleModal(deleteConfirmationModal, false);
                deleteForm = null;
            }

            confirmDeleteBtn.addEventListener('click', function() {
                if (deleteForm) {
                    deleteForm.submit();
                }
            });

            // Restore Confirmation with SweetAlert
            document.querySelectorAll('.btn-restore').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent form submission
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Restore',
                        text: 'Apakah Anda yakin ingin mengembalikan pesanan ini ke halaman orders?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Restore',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#d3d3d3'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pesanan telah direstore.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>