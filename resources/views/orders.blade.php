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
                <!-- Order Card 1 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78945</span>
                        <span class="text-xs text-gray-500">10 min ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">John Smith</p>
                                <p class="text-xs text-gray-500">3 items • $28.97</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">2 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Nasi Goreng</span>
                                <span class="font-medium">1 × $12.00</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Ayam Bakar</span>
                                <span class="font-medium">1 × $13.97</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$28.97</p>
                            </div>
                            <span class="status-badge bg-green-100 text-green-800">Completed</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 2 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78944</span>
                        <span class="text-xs text-gray-500">25 min ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Sarah Johnson</p>
                                <p class="text-xs text-gray-500">5 items • $45.50</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">3 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Mie Goreng</span>
                                <span class="font-medium">2 × $10.00</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Sate Ayam</span>
                                <span class="font-medium">1 × $15.00</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Lumpia</span>
                                <span class="font-medium">2 × $3.50</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$45.50</p>
                            </div>
                            <span class="status-badge bg-yellow-100 text-yellow-800">Processing</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 3 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78943</span>
                        <span class="text-xs text-gray-500">1 hour ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Michael Brown</p>
                                <p class="text-xs text-gray-500">2 items • $18.99</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">1 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Bakso</span>
                                <span class="font-medium">1 × $17.49</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$18.99</p>
                            </div>
                            <span class="status-badge bg-blue-100 text-blue-800">On Delivery</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 4 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78942</span>
                        <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Emily Davis</p>
                                <p class="text-xs text-gray-500">4 items • $36.75</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">2 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Nasi Padang</span>
                                <span class="font-medium">1 × $15.00</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Rendang</span>
                                <span class="font-medium">1 × $18.75</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$36.75</p>
                            </div>
                            <span class="status-badge bg-red-100 text-red-800">Cancelled</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 5 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78941</span>
                        <span class="text-xs text-gray-500">3 hours ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Robert Wilson</p>
                                <p class="text-xs text-gray-500">1 item • $9.99</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">1 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Gado-Gado</span>
                                <span class="font-medium">1 × $8.49</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$9.99</p>
                            </div>
                            <span class="status-badge bg-purple-100 text-purple-800">Pending</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 6 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78940</span>
                        <span class="text-xs text-gray-500">5 hours ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Jessica Lee</p>
                                <p class="text-xs text-gray-500">3 items • $24.50</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">2 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Soto Ayam</span>
                                <span class="font-medium">1 × $10.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Pempek</span>
                                <span class="font-medium">1 × $12.50</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$24.50</p>
                            </div>
                            <span class="status-badge bg-yellow-100 text-yellow-800">Processing</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 7 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78939</span>
                        <span class="text-xs text-gray-500">1 day ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">David Kim</p>
                                <p class="text-xs text-gray-500">2 items • $17.25</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">1 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Nasi Uduk</span>
                                <span class="font-medium">1 × $15.75</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$17.25</p>
                            </div>
                            <span class="status-badge bg-green-100 text-green-800">Completed</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Card 8 -->
                <div class="order-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium">#ORD-78938</span>
                        <span class="text-xs text-gray-500">1 day ago</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/19.jpg" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">Amanda Chen</p>
                                <p class="text-xs text-gray-500">6 items • $52.80</p>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mb-3">
                            <div class="order-item flex justify-between">
                                <span>Es Teh Manis</span>
                                <span class="font-medium">4 × $1.50</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Nasi Campur</span>
                                <span class="font-medium">1 × $18.00</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Ayam Goreng</span>
                                <span class="font-medium">1 × $14.80</span>
                            </div>
                            <div class="order-item flex justify-between">
                                <span>Tempe Goreng</span>
                                <span class="font-medium">2 × $3.00</span>
                            </div>
                        </div>
                        
                        <!-- Total and Status -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-bold">$52.80</p>
                            </div>
                            <span class="status-badge bg-blue-100 text-blue-800">On Delivery</span>
                        </div>
                    </div>
                </div>
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
        });
    </script>
</body>
</html>