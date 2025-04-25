
<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodExpress</title>
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
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .order-row:hover {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include("layouts.app")
    
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
                <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
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
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Total Revenue</p>
                            <h3 class="text-2xl font-bold">$12,345</h3>
                            <p class="text-sm text-green-500 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Total Orders</p>
                            <h3 class="text-2xl font-bold">1,234</h3>
                            <p class="text-sm text-green-500 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i> 8% from last month
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Active Customers</p>
                            <h3 class="text-2xl font-bold">856</h3>
                            <p class="text-sm text-green-500 mt-1">
                                <i class="fas fa-arrow-up mr-1"></i> 5% from last month
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Menu Items</p>
                            <h3 class="text-2xl font-bold">48</h3>
                            <p class="text-sm text-red-500 mt-1">
                                <i class="fas fa-arrow-down mr-1"></i> 2% from last month
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-utensils text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Revenue Chart -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Revenue Overview</h3>
                        <select class="bg-gray-100 border-0 rounded-lg px-3 py-1 text-sm">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option selected>Last 90 Days</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                
                <!-- Order Types Chart -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Order Types</h3>
                        <select class="bg-gray-100 border-0 rounded-lg px-3 py-1 text-sm">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option selected>Last 90 Days</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="orderTypesChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg">Recent Orders</h3>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View All
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-gray-500 text-left">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Items</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="order-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">#ORD-78945</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="w-8 h-8 rounded-full mr-2">
                                        <span>John Smith</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">3</td>
                                <td class="px-6 py-4 whitespace-nowrap">$28.97</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">10 min ago</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="order-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">#ORD-78944</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Customer" class="w-8 h-8 rounded-full mr-2">
                                        <span>Sarah Johnson</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">5</td>
                                <td class="px-6 py-4 whitespace-nowrap">$45.50</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Processing</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">25 min ago</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="order-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">#ORD-78943</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Customer" class="w-8 h-8 rounded-full mr-2">
                                        <span>Michael Brown</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">2</td>
                                <td class="px-6 py-4 whitespace-nowrap">$18.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">On Delivery</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">1 hour ago</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="order-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">#ORD-78942</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Customer" class="w-8 h-8 rounded-full mr-2">
                                        <span>Emily Davis</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">4</td>
                                <td class="px-6 py-4 whitespace-nowrap">$36.75</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">2 hours ago</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Popular Items -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-bold text-lg">Popular Menu Items</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="p-4 flex items-center">
                            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                                 alt="Classic Burger" class="w-16 h-16 rounded-lg object-cover">
                            <div class="ml-4 flex-1">
                                <h4 class="font-medium">Classic Burger</h4>
                                <p class="text-sm text-gray-500">Food • 320 orders</p>
                            </div>
                            <span class="text-blue-600 font-medium">$8.99</span>
                        </div>
                        <div class="p-4 flex items-center">
                            <img src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2a1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                                 alt="Iced Coffee" class="w-16 h-16 rounded-lg object-cover">
                            <div class="ml-4 flex-1">
                                <h4 class="font-medium">Iced Coffee</h4>
                                <p class="text-sm text-gray-500">Drink • 280 orders</p>
                            </div>
                            <span class="text-blue-600 font-medium">$3.99</span>
                        </div>
                        <div class="p-4 flex items-center">
                            <img src="https://images.unsplash.com/photo-1561758033-d89a9ad46330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" 
                                 alt="Margherita Pizza" class="w-16 h-16 rounded-lg object-cover">
                            <div class="ml-4 flex-1">
                                <h4 class="font-medium">Margherita Pizza</h4>
                                <p class="text-sm text-gray-500">Food • 245 orders</p>
                            </div>
                            <span class="text-blue-600 font-medium">$12.99</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-bold text-lg">Recent Reviews</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="User" class="w-8 h-8 rounded-full mr-2">
                                    <span class="font-medium">Lisa Ray</span>
                                </div>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-600">"The burger was amazing! Will definitely order again."</p>
                            <p class="text-xs text-gray-400 mt-2">2 hours ago • Classic Burger</p>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="User" class="w-8 h-8 rounded-full mr-2">
                                    <span class="font-medium">David Miller</span>
                                </div>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-600">"Pizza was good but delivery took longer than expected."</p>
                            <p class="text-xs text-gray-400 mt-2">5 hours ago • Margherita Pizza</p>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="User" class="w-8 h-8 rounded-full mr-2">
                                    <span class="font-medium">Sophia Wilson</span>
                                </div>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-600">"Love the iced coffee, perfect for hot days!"</p>
                            <p class="text-xs text-gray-400 mt-2">1 day ago • Iced Coffee</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Revenue',
                        data: [4500, 5200, 4800, 5900, 6200, 7000, 7300],
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Order Types Chart
            const orderTypesCtx = document.getElementById('orderTypesChart').getContext('2d');
            const orderTypesChart = new Chart(orderTypesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Dine-in', 'Takeaway', 'Delivery'],
                    datasets: [{
                        data: [35, 25, 40],
                        backgroundColor: [
                            '#3b82f6',
                            '#6366f1',
                            '#8b5cf6'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>